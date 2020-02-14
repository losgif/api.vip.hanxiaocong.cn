<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationController extends Controller
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
        return view('information');
    }
    
    public function open(Request $request)
    {
        $this->validate($request, [
            'array' => 'required'
        ]);

        $ids = json_decode($request->array, true);

        Info::whereIn('id', $ids)->update([
            'is_active' => 1
        ]);

        foreach ($ids as $key => $value) {
            $infos[$key] = Info::find($value)->toArray();
        }

        return view('open',compact('infos'));
    }

    public function getAllInfo(Request $request)
    {
        $filters = $request->filters;

        $user = Auth::user();

        if ($user->is_admin) {
            $info = new Info();
        } else {
            $info = $user->info();
        }
        
        if (isset($filters['school_id']) and !empty($filters['school_id'])) {
            $info = $info->whereIn('school_id', $filters['school_id']);
        }

        if (isset($filters['sex']) and !empty($filters['sex'])) {
            $info = $info->whereIn('sex', $filters['sex']);
        }

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
