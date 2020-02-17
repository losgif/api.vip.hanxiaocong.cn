<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SchoolApplication;

class SiteController extends Controller
{
    public function show(SchoolApplication $schoolApplication)
    {
        return $this->success($schoolApplication->name);
    }
}
