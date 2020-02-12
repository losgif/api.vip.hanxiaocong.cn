<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Info;
use App\School;

class IndexController extends Controller
{
    
    public function upload(Request $request, Info $info)
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
            'school_id' => 'sometimes'
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
        
        if (isset($request->school_id)) {
            $school = School::where('id', $request->school_id)->first();

            if (empty($school)) {
                return "非法请求";
            } else {
                $info->school_name = $school->name;
            }
            
            $info->school_id = $request->school_id;

            $result = $info->save();

            $disk = Storage::disk('qiniu');
    
            $token = $disk->getUploadToken();
    
            $domain = config('filesystems.disks.qiniu.domain');

            $schoolName = School::where('id', $request->school_id )->first()->name;
    
            return view('school')->with([
                'token' => $token,
                'domain' => $domain,
                'schoolName' => $schoolName,
                'school' => $request->school_id,
                'result' => $result
            ]);
        } else {
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

        $schoolName = School::where('id', $school)->first()->name;

        return view('school')->with([
            'token' => $token,
            'domain' => $domain,
            'schoolName' => $schoolName,
            'school' => $school,
            'result' => 0
        ]);
    }
}
