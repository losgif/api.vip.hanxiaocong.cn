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
        $user = Auth::user();
        $applications = $user->application;

        return $this->success($applications);
    }
    
    public function activity(Request $request)
    {
        $user = Auth::user();
        $applications = $user->application;

        return $this->success($applications);
    }
}
