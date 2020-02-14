<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;

class SiteController extends Controller
{
    public function show(School $school)
    {
        return $this->success($school->name);
    }
}
