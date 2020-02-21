<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application;
use App\SchoolApplication;
use App\SchoolApplicationKeyword;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;

class SchoolApplicationController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => ['required'],
            'name' => ['required'],
            'keyword' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();

        try {
            $user = Auth::user();
            
            $application = Application::where('id', $request->application_id)->first();
            $school = $user->school()->first();
            
            $schoolApplication = new SchoolApplication;
            $schoolApplication->school_id = $school->id;
            $schoolApplication->application_id = $application->id;
            $schoolApplication->name = $request->name;
            $schoolApplication->type = $application->type;
            $schoolApplication->description = $application->description;
            $schoolApplication->logo = $application->logo;

            $schoolApplication->save();

            foreach ($request->keyword as $keyword) {
                $hasKeyword = $school->keyword()->where('keyword', $keyword)->first();

                if ($hasKeyword) {
                    return $this->failed("关键词{$keyword}已存在");
                }
                
                SchoolApplicationKeyword::create([
                    'school_application_id' => $schoolApplication->id,
                    'keyword' => $keyword,
                ]);
            }

            $result['application_type'] = $application->type;
            
            $schoolApplication->config = $result;
            $schoolApplication->save();
            
            DB::commit();

            return $this->success('创建成功');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->failed($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolApplication $schoolApplication)
    {
        return $this->success($schoolApplication);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolApplication $schoolApplication)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'keyword' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $hasSchoolApplication = $user->application()->where('school_applications.id', $schoolApplication->id)->first();
            $school = $user->school()->first();

            if (empty($hasSchoolApplication) && !$user->hasRole('super-admin')) {
                return $this->failed("非法请求");
            }
            
            $schoolApplication->name = $request->name;
            $schoolApplication->save();

            // foreach ($request->keyword as $keyword) {
            //     $hasKeyword = $school->keyword()->where('keyword', $keyword)->first();

            //     if ($hasKeyword) {
            //         return $this->failed("关键词{$keyword}已存在");
            //     }
                
            //     SchoolApplicationKeyword::create([
            //         'school_application_id' => $schoolApplication->id,
            //         'keyword' => $keyword,
            //     ]);
            // }

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
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolApplication $schoolApplication)
    {
        //
    }
}
