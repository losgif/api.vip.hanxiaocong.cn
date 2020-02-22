<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Information;
use App\SchoolApplication;
use zgldh\QiniuStorage\QiniuStorage;

class UploadController extends Controller
{
    /**
     * 生成上传Token
     *
     * @param Request $request
     * @return Response
     */
    public function fetchToken(Request $request)
    {
        try {
            $disk = QiniuStorage::disk('qiniu');
            
            $response['token'] = $disk->uploadToken();
            $response['domain'] = config('filesystems.disks.qiniu.domains.default');
    
            return $this->success($response);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    /**
     * 上传信息处理函数
     *
     * @param Request $request
     * @param Information $information
     * @return Response
     */
    public function info(Request $request, Information $information)
    {   
        $validator = Validator::make($request->all(), [
            'school_application_id' => [
                'required',
            ]
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }
        
        $schoolApplication = SchoolApplication::where('id', $request->school_application_id)->first();

        if (empty($schoolApplication)) {
            return $this->failed('应用不存在，请联系管理员');
        }

        $type = $schoolApplication->type;

        switch ($type) {
            case 'goddess':
                return $this->handleGoddess($request, $information);
                break;

            case 'roommate':
                return $this->handleRoommate($request, $information);
                break;
            
            default:
                return $this->failed('应用参数错误，请联系管理员');
                break;
        }
    }

    public function handleRoommate(Request $request, Information $information)
    {
        $validator = Validator::make($request->all(), [
            'ta_name' => [
                'required',
            ],
            'sex' => [
                'required'
            ],
            'ta_contact_account' => [
                'required'
            ],
            'university' => [
                'required'
            ],
            'your_contact_account' => [
                'required'
            ],
            'height' => [
                'required'
            ],
            'origin' => [
                'required'
            ],
            'specialty' => [
                'required'
            ],
            'expectation' => [
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
            $information->school_application_id = $request->school_application_id;

            $extra = [];

            $extra['ta_name'] = $request->ta_name;
            $extra['sex'] = $request->sex;
            $extra['ta_contact_account'] = $request->ta_contact_account;
            $extra['university'] = $request->university;
            $extra['your_contact_account'] = $request->your_contact_account;
            $extra['height'] = $request->height;
            $extra['origin'] = $request->origin;
            $extra['specialty'] = $request->specialty;
            $extra['expectation'] = $request->expectation;

            if (config('filesystems.default') == 'qiniu') {
                $path = $request->person_image;
            } else {
                $path = config('app.url') . $request->person_image;
            }
            $extra['person_image'] = $path;
            
            $information->extra = \json_encode($extra);
            $information->save();

            DB::commit();

            return $this->success('添加成功');
        } catch (\Throwable $th) {
            DB::rollback();
            
            return $this->failed($th->getMessage());
        }
    }
    
    public function handleGoddess(Request $request, Information $information)
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
            $information->school_application_id = $request->school_application_id;

            $extra = [];

            $extra['name'] = $request->name;
            $extra['sex'] = $request->sex;
            $extra['contact_account'] = $request->contact_account;
            $extra['university'] = $request->university;
            $extra['department'] = $request->department;
            $extra['height'] = $request->height;
            $extra['constellation'] = $request->constellation;
            $extra['origin'] = $request->origin;
            $extra['weibo'] = $request->weibo;
            $extra['specialty'] = $request->specialty;
            $extra['person_image'] = $request->person_image;

            $extra['extensions'] = [];

            if (isset($request->question_1) and !empty($request->question_1)) {
                $extra['extensions']['question_1']['title'] = "自我评价";
                $extra['extensions']['question_1']['content'] = $request->question_1;
                if (isset($request->question_image_1) and !empty($request->question_image_1)) {
                    $extra['extensions']['question_1']['image'] = $request->question_image_1;
                } else {
                    unset($extra['extensions']['question_1']);
                }
            }

            if (isset($request->question_2) and !empty($request->question_2)) {
                $extra['extensions']['question_2']['title'] = "爱情观";
                $extra['extensions']['question_2']['content'] = $request->question_2;
                if (isset($request->question_image_2) and !empty($request->question_image_2)) {
                    $extra['extensions']['question_2']['image'] = $request->question_image_2;
                } else {
                    unset($extra['extensions']['question_2']);
                }
            }
            
            if (isset($request->question_3) and !empty($request->question_3)) {
                $extra['extensions']['question_3']['title'] = "在大学的改变";
                $extra['extensions']['question_3']['content'] = $request->question_3;
                if (isset($request->question_image_3) and !empty($request->question_image_3)) {
                    $extra['extensions']['question_3']['image'] = $request->question_image_3;
                } else {
                    unset($extra['extensions']['question_3']);
                }
            }

            if (isset($request->question_4) and !empty($request->question_4)) {
                $extra['extensions']['question_4']['title'] = "生活中发生过的囧事";
                $extra['extensions']['question_4']['content'] = $request->question_4;
                if (isset($request->question_image_4) and !empty($request->question_image_4)) {
                    $extra['extensions']['question_4']['image'] = $request->question_image_4;
                } else {
                    unset($extra['extensions']['question_4']);
                }
            }

            if (isset($request->question_5) and !empty($request->question_5)) {
                $extra['extensions']['question_5']['title'] = "喜欢的偶像";
                $extra['extensions']['question_5']['content'] = $request->question_5;
                if (isset($request->question_image_5) and !empty($request->question_image_5)) {
                    $extra['extensions']['question_5']['image'] = $request->question_image_5;
                } else {
                    unset($extra['extensions']['question_5']);
                }
            }

            if (isset($request->question_6) and !empty($request->question_6)) {
                $extra['extensions']['question_6']['title'] = "参加活动的收获";
                $extra['extensions']['question_6']['content'] = $request->question_6;
                if (isset($request->question_image_6) and !empty($request->question_image_6)) {
                    $extra['extensions']['question_6']['image'] = $request->question_image_6;
                } else {
                    unset($extra['extensions']['question_6']);
                }
            }

            if (isset($request->question_7) and !empty($request->question_7)) {
                $extra['extensions']['question_7']['title'] = "未来规划";
                $extra['extensions']['question_7']['content'] = $request->question_7;
                if (isset($request->question_image_7) and !empty($request->question_image_7)) {
                    $extra['extensions']['question_7']['image'] = $request->question_image_7;
                } else {
                    unset($extra['extensions']['question_7']);
                }
            }

            if (isset($request->question_8) and !empty($request->question_8)) {
                $extra['extensions']['question_8']['title'] = "小梦想";
                $extra['extensions']['question_8']['content'] = $request->question_8;
                if (isset($request->question_image_8) and !empty($request->question_image_8)) {
                    $extra['extensions']['question_8']['image'] = $request->question_image_8;
                } else {
                    unset($extra['extensions']['question_8']);
                }
            }

            if (isset($request->question_9) and !empty($request->question_9)) {
                $extra['extensions']['question_9']['title'] = "对学弟学妹说的话";
                $extra['extensions']['question_9']['content'] = $request->question_9;
                if (isset($request->question_image_9) and !empty($request->question_image_9)) {
                    $extra['extensions']['question_9']['image'] = $request->question_image_9;
                } else {
                    unset($extra['extensions']['question_9']);
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
    
    /**
     * 上传图片处理函数
     *
     * @param Request $request
     * @return Response
     */
    public function image(Request $request)
    {
        try {
            $validMimeType = [
                'image/webp',
                'image/png',
                'image/jpeg',
                'image/gif',
            ];
            if ($request->hasFile('image')) {
                $extension = $request->image->getClientMimeType();
    
                if (!in_array($extension, $validMimeType)) {
                    return $this->failed('请上传图片文件');
                }

                $size = $request->image->getClientSize();
                $size5M = 1024 * 1024 * 5;

                if ($size > $size5M) {
                    return $this->failed('图片需要小于5M');
                }
    
                $path = $request->image->store('images');
    
                if (config('filesystems.default') == 'qiniu') {
                    $path = config('filesystems.disks.qiniu.domains.default') . $path;
                } else {
                    $path = config('app.url') .$path;
                }
    
                return $this->success($path);
            } else {
                return $this->failed('系统错误');
            }
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
