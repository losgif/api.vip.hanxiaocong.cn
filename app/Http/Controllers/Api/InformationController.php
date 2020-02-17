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
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }
        
        try {
            $validateToken = $this->validateToken($request->token);

            if ($validateToken) {
                $information = Information::where('id', $request->id)->first();

                if ($information) {
                    return $this->success($information->contact_account);
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
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        try {
            $user = Auth::user();
            
            $schoolApplication = $user->application->where('id', $request->id)->first();

            $informations = $schoolApplication->information()->orderBy('id', 'desc')->paginate();

            return $this->success($informations);
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
}
