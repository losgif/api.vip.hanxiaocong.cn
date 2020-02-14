<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Information;
use App\School;

class UploadController extends Controller
{
    public function info(Request $request, Information $information)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
            ],
            'sex' => [
                'required'
            ],
            'contact_account' => [
                'required'
            ],
            'university' => [
                'required'
            ],
            'department' => [
                'required'
            ],
            'height' => [
                'required'
            ],
            'constellation' => [
                'required'
            ],
            'origin' => [
                'required'
            ],
            'weibo' => [
                'required'
            ],
            'specialty' => [
                'required'
            ],
            'person_image' => [
                'required'
            ],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();

        try {
            $information->name = $request->name;
            $information->sex = $request->sex;
            $information->contact_account = $request->contact_account;
            $information->university = $request->university;
            $information->department = $request->department;
            $information->height = $request->height;
            $information->constellation = $request->constellation;
            $information->origin = $request->origin;
            $information->weibo = $request->weibo;
            $information->specialty = $request->specialty;
            $information->person_image = $request->person_image[0]['url'];

            if (isset($request->school_id) and !empty($request->school_id)) {
                $information->school_id = $request->school_id;

                $school = School::where('id', $request->school_id)->first();

                if ($school) {
                    $information->school_name = $school->name;
                } else {
                    $information->school_id = 0;
                    $information->school_name = "系统默认";
                }
            } else {
                $information->school_id = 0;
                $information->school_name = "系统默认";
            }

            $extra = [];

            if (isset($request->question_1) and !empty($request->question_1)) {
                $extra['question_1']['title'] = "女神/男神对自己的评价（感觉自己是什么样的人）？";
                $extra['question_1']['content'] = $request->question_1;
                if (isset($request->question_image_1) and !empty($request->question_image_1)) {
                    $extra['question_1']['image'] = $request->question_image_1[0]['url'];
                } else {
                    unset($extra['question_1']);
                }
            }

            if (isset($request->question_2) and !empty($request->question_2)) {
                $extra['question_2']['title'] = "女神/男神是单身还是有男or女票呢？喜欢什么类型的异性？";
                $extra['question_2']['content'] = $request->question_2;
                if (isset($request->question_image_2) and !empty($request->question_image_2)) {
                    $extra['question_2']['image'] = $request->question_image_2[0]['url'];
                } else {
                    unset($extra['question_2']);
                }
            }
            
            if (isset($request->question_3) and !empty($request->question_3)) {
                $extra['question_3']['title'] = "女神/男神在大学期间的经历，有什么改变？";
                $extra['question_3']['content'] = $request->question_3;
                if (isset($request->question_image_3) and !empty($request->question_image_3)) {
                    $extra['question_3']['image'] = $request->question_image_3[0]['url'];
                } else {
                    unset($extra['question_3']);
                }
            }

            if (isset($request->question_4) and !empty($request->question_4)) {
                $extra['question_4']['title'] = "女神/男神在生活中发生过的囧事？";
                $extra['question_4']['content'] = $request->question_4;
                if (isset($request->question_image_4) and !empty($request->question_image_4)) {
                    $extra['question_4']['image'] = $request->question_image_4[0]['url'];
                } else {
                    unset($extra['question_4']);
                }
            }

            if (isset($request->question_5) and !empty($request->question_5)) {
                $extra['question_5']['title'] = "女神/男神有喜欢的偶像（科学家/明星）吗？";
                $extra['question_5']['content'] = $request->question_5;
                if (isset($request->question_image_5) and !empty($request->question_image_5)) {
                    $extra['question_5']['image'] = $request->question_image_5[0]['url'];
                } else {
                    unset($extra['question_5']);
                }
            }

            if (isset($request->question_6) and !empty($request->question_6)) {
                $extra['question_6']['title'] = "女神/男神有没有参加过什么社团、组织、活动啊，自己的收获是什么？";
                $extra['question_6']['content'] = $request->question_6;
                if (isset($request->question_image_6) and !empty($request->question_image_6)) {
                    $extra['question_6']['image'] = $request->question_image_6[0]['url'];
                } else {
                    unset($extra['question_6']);
                }
            }

            if (isset($request->question_7) and !empty($request->question_7)) {
                $extra['question_7']['title'] = "女神/男神对自己未来的规划？";
                $extra['question_7']['content'] = $request->question_7;
                if (isset($request->question_image_7) and !empty($request->question_image_7)) {
                    $extra['question_7']['image'] = $request->question_image_7[0]['url'];
                } else {
                    unset($extra['question_7']);
                }
            }

            if (isset($request->question_8) and !empty($request->question_8)) {
                $extra['question_8']['title'] = "女神/男神有什么小梦想？";
                $extra['question_8']['content'] = $request->question_8;
                if (isset($request->question_image_8) and !empty($request->question_image_8)) {
                    $extra['question_8']['image'] = $request->question_image_8[0]['url'];
                } else {
                    unset($extra['question_8']);
                }
            }

            if (isset($request->question_9) and !empty($request->question_9)) {
                $extra['question_9']['title'] = "女神/男神有什么要对学弟学妹说的话？";
                $extra['question_9']['content'] = $request->question_9;
                if (isset($request->question_image_9) and !empty($request->question_image_9)) {
                    $extra['question_9']['image'] = $request->question_image_9[0]['url'];
                } else {
                    unset($extra['question_9']);
                }
            }

            $information->extra = \json_encode($extra);

            $information->save();

            DB::commit();

            return $this->success('添加成功');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->failed($th->getMessage());
        }
    }
    
    public function image(Request $request)
    {
        if ($request->hasFile('image') and $request->file('image')->isValid()) {
            $path = $request->image->store('images');

            if (config('filesystems.default') == 'qiniu') {
                $path = config('filesystems.disks.qiniu.domain') . $path;
            } else {
                $path = config('app.url') .$path;
            }

            return $path;
        } else {
            return $this->failed('文件不合法');
        }
    }
}