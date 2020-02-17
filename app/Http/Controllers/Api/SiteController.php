<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\School;

class SiteController extends Controller
{
    public function show(School $school)
    {
        return $this->success($school->name);
    }
}
