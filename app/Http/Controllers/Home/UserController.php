<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->is_admin) {
            $users = User::orderBy('id', 'desc')->paginate(10);
        } else {
            $users = false;
        }
        
        if ($users) {
            $rsp['errorCode'] = 0;
            $rsp['errorMsg'] = $users;
        } else {
            $rsp['errorCode'] = 1;
            $rsp['errorMsg'] = '获取失败';
        }

        return response()->json($rsp);
    }

    public function update(Request $request, User $user)
    {   
        $user->status = $request->status;
        $result = $user->save();

        if ($result) {
            $rsp['errorCode'] = 0;
            $rsp['errorMsg'] = $result;
        } else {
            $rsp['errorCode'] = 1;
            $rsp['errorMsg'] = '更新失败';
        }

        return response()->json($rsp);
    }
}