<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
use Auth;

class SchoolController extends Controller
{
    public function index(School $school)
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            $school = $school->orderBy('id', 'desc')->paginate(10);
        } else {
            $school = $school->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        }

        if ($school) {
            $rsp['errorCode'] = 0;
            $rsp['errorMsg'] = $school;
        } else {
            $rsp['errorCode'] = 1;
            $rsp['errorMsg'] = '获取失败';
        }

        return response()->json($rsp);
    }

    public function store(Request $request, School $school)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $user = Auth::user();

        $school->user_id = $user->id;
        $school->name = $request->name;
        $result = $school->save();

        if ($result) {
            $rsp['errorCode'] = 0;
            $rsp['errorMsg'] = $result;
        } else {
            $rsp['errorCode'] = 1;
            $rsp['errorMsg'] = '获取失败';
        }

        return response()->json($rsp);
    }

    public function delete(Request $request)
    {
        $user = Auth::user();

        if ($user->is_admin) {
            $result = School::where('id', $request->id)->delete();
        } else {
            $result = School::where('user_id', $user->id)->where('id', $request->id)->delete();
        }

        if ($result) {
            $rsp['errorCode'] = 0;
            $rsp['errorMsg'] = $result;
        } else {
            $rsp['errorCode'] = 1;
            $rsp['errorMsg'] = '删除失败';
        }

        return response()->json($rsp);
    }

    public function getFilters(School $school)
    {
        $user = Auth::user();

        if ($user->is_admin) {
            $school = $school->get();
        } else {
            $school = $school->where('user_id', $user->id)->get();
        }

        if ($school) {
            $result = [];
            $school->each(function($s) use (&$result) {
                $result[] = [
                    'text' => $s->name,
                    'value' => $s->id
                ];

            });
            
            $rsp['errorCode'] = 0;
            $rsp['errorMsg'] = $result;
        } else {
            $rsp['errorCode'] = 1;
            $rsp['errorMsg'] = '获取失败';
        }

        return response()->json($rsp);
    }
}