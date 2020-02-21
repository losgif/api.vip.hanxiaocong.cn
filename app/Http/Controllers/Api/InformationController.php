<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Information;
use App\SchoolApplication;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Services\UrlSign;
use Auth;

class InformationController extends Controller
{
    use UrlSign;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 获取联系方式函数
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => [
                'required'
            ],
            'id' => [
                'required'
            ],
            'type' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }
        
        try {
            $validateToken = $this->validateToken($request->token);

            if ($validateToken) {
                $information = Information::where('id', $request->id)->first();

                if ($information) {
                    switch ($request->type) {
                        case 'goddess':
                            return $this->success($information->extra->contact_account);
                            break;

                        case 'roommate':
                            return $this->success($information->extra->ta_contact_account);
                            break;
                        
                        default:
                            return $this->failed('你似乎是非法请求');
                            break;
                    }
                    
                    
                } else {
                    return $this->failed('查无此信息');
                }
            } else {
                return $this->failed('联系方式已过期');
            }
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    /**
     * Display a listing of the resource by application id.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByApplicationId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => [
                'required'
            ],
            'pageSize' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        try {
            $user = Auth::user();
            
            if ($user->hasRole('super-admin')) {
                $schoolApplication = SchoolApplication::where('id', (int)$request->id)->first();
            } else {
                $schoolApplication = $user->application->where('id', (int)$request->id)->first();
            }

            if (empty($schoolApplication)) {
                return $this->failed('应用不存在', 403);
            }

            $informations = $schoolApplication->information()->orderBy('id', 'desc')->paginate($request->pageSize);

            return $this->success($informations);
        } catch (\Throwable $th) {
            throw $th;
            return $this->failed($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        //
    }

    public function batchDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keys' => [
                'required'
            ],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }
        
        DB::beginTransaction();
        
        try {
            $user = Auth::user();
            
            $school = $user->school()->first();

            $school->information()->whereIn('information.id', $request->keys)->delete();

            DB::commit();

            return $this->success('删除成功');
        } catch (\Throwable $th) {
            DB::rollback();
            
            return $this->failed($th->getMessage());
        }
    }

    public function preview(Request $request, SchoolApplication $schoolApplication)
    {
        $this->validate($request, [
            'array' => 'required',
            'type'  => 'required',
            'id'    => 'required'
        ]);

        $ids = json_decode($request->array, true);

        Information::whereIn('id', $ids)->update([
            'is_active' => 1
        ]);

        $schoolApplicationkeyword = $schoolApplication->where('id', $request->id)->first()->keyword()->first();

        if (empty($schoolApplicationkeyword)) {
            // return $this->failed('未配置关键词，请联系管理员');
            return '未配置关键词，请联系管理员';
        }

        $keyword = $schoolApplicationkeyword->keyword;

        foreach ($ids as $key => $value) {
            $infos[$key] = Information::find($value)->toArray();
        }

        return view('preview.' . $request->type, compact('infos'))->with('keyword', $keyword);
    }
}
