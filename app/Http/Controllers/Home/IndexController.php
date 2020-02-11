<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Info;

class IndexController extends Controller
{
    
    public function upload (Request $request, Info $info)
    {
        $this->validate($request, [
            'name' => 'required',
            'sex' => 'required',
            'grade' => 'required',
            'height' => 'required',
            'ta_tel' => 'required',
          	'my_tel'=> 'required',
            'brith_place' => 'required',
            'detail' => 'required',
            'expect' => 'required',
        ]);

        $info->name = $request->name;
        $info->sex = $request->sex;
        $info->grade = $request->grade;
        $info->ta_tel = isset($request->ta_tel) ? $request->ta_tel : '';
        $info->my_tel = isset($request->my_tel) ? $request->my_tel : '';
        $info->height = $request->height;
        $info->brith_place = $request->brith_place;
        $info->upload_url = isset($request->upload_url) ? $request->upload_url : '';
        $info->detail = $request->detail;
        $info->expect = $request->expect;
    
        $result = $info->save();

        $disk = Storage::disk('qiniu');

        $token = $disk->getUploadToken();

        $domain = config('filesystems.disks.qiniu.domain');

        return view('welcome')->with([
            'token' => $token,
            'domain' => $domain,
            'result' => $result
        ]);
    }

    public function generate(Request $request)
    {
        
    }

    public function index()
    {
        $disk = Storage::disk('qiniu');

        $token = $disk->getUploadToken();
        $domain = config('filesystems.disks.qiniu.domain');

        return view('welcome')->with([
            'token' => $token,
            'domain' => $domain,
            'result' => 0
        ]);
    }

    public function school($school)
    {
        $disk = Storage::disk('qiniu');
       
        $token = $disk->getUploadToken();
        $domain = config('filesystems.disks.qiniu.domain');

        return view('school')->with([
            'token' => $token,
            'domain' => $domain,
            'school' => $school,
            'result' => 0
        ]);
    }
}
