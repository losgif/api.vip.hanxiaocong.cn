<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SchoolApplication;
use Auth;

class WorkplaceController extends Controller
{
    public function applications(Request $request)
    {
        try {
            $user = Auth::user();
            $applications = $user->application;
    
            return $this->success($applications);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
    
    public function activity(Request $request)
    {
        try {
            $user = Auth::user();
        
            $school = $user->school()->withCount('information')->first();

            if (empty($school)) {
                return $this->failed('请绑定公众号');
            }
    
            $informations = $school->information()->where('is_active', 0)->with('application')->orderBy('id', 'desc')->limit(10)->get();
    
            return $this->success($informations);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
    
    public function data(Request $request)
    {
        try {
            $user = Auth::user();
        
            $count = $user->school()->first()->information()->count();
    
            return $this->success($count);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
