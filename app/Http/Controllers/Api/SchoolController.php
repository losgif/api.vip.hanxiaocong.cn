<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\School;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Validation\Rule;
use Auth;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::user();
        
            $school = $user->school;

            $school = $school->map(function($s) {
                $s['api'] = config('app.url') . '/api/wechat/' . $s->id;

                return $s;
            });
            
            return $this->success($school);
        } catch (\Throwable $th) {
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
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'media_number' => ['required'],
            'media_id' => ['required', 'unique:schools'],
            'token' => ['sometimes', 'between:3,32', 'alpha_num'],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();
        
        try {
            $user = Auth::user();

            $school = $user->school;

            if (!empty($school) && !$school->isEmpty()) {
                return $this->failed('已经配置过公众号');
            }
            
            $school = new School;
            $school->name = $request->name;
            $school->media_number = $request->media_number;
            $school->media_id = $request->media_id;
            $school->user_id = $user->id;

            if (empty($request->token)) {
                $school->token = str_random(32);
            } else {
                $school->token = $request->token;
            }
            
            $school->save();

            if ($user->hasRole('vistor')) {
                $user->removeRole('vistor');
            }
            
            $user->assignRole('normal-user');

            DB::commit();

            return $this->success('添加成功');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->failed($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'media_number' => ['required'],
            'media_id' => ['required', Rule::unique('schools')->ignore($school->id)],
            'token' => ['sometimes', 'between:3,32', 'alpha_num'],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();
        
        try {
            $user = Auth::user();

            $school = $user->school()->where('id', $school->id)->first();

            if (empty($school)) {
                return $this->failed('非法请求');
            }

            $school->name = $request->name;
            $school->media_number = $request->media_number;
            $school->media_id = $request->media_id;
            $school->user_id = $user->id;

            if (empty($request->token)) {
                $school->token = str_random(32);
            } else {
                $school->token = $request->token;
            }
            
            $school->save();

            DB::commit();

            return $this->success('更新成功');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->failed($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        //
    }
}
