<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\SchoolApplication;
use Illuminate\Http\Request;
use Validator;
use DB;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pageSize' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }
        
        try {
            $users = SchoolApplication::with([
                'school' => function ($s) {
                    $s->with('user');
                }
            ])->orderBy('id', 'desc')->withCount('information')->paginate($request->pageSize);

            return $this->success($users);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolApplication $schoolApplication)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolApplication $schoolApplication)
    {
        DB::beginTransaction();
        
        try {
            $schoolApplication->delete();

            DB::commit();
            
            return $this->success('删除成功');
        } catch (\Throwable $th) {
            DB::rollback();
            
            return $this->failed($th->getMessage());
        }
    }
}
