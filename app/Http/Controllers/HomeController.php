<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Kernel\Messages\Text;
use App\Info;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        return view('home');
    }

    public function open(Request $request){
        $this->validate($request, [
            'array' => 'required'
        ]);

        $ids = json_decode($request->array);

        foreach ($ids as $key => $value) {
            $infos[$key] = Info::find($value)->toArray();
        }

        return view('open',compact('infos'));
    }

    public function getAllInfo(Request $request, Info $info)
    {
        $info = $info->orderBy('id', 'desc')->paginate(10);

        if ($info) {
            $rsp['errorCode'] = 0;
            $rsp['errorMsg'] = $info;
        } else {
            $rsp['errorCode'] = 1;
            $rsp['errorMsg'] = '获取失败';
        }

        return response()->json($rsp);
    }

}
