<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SchoolApplication;
use Illuminate\Http\Request;

class SchoolApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolApplication $schoolApplication)
    {
        return $this->success($schoolApplication);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolApplication $schoolApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolApplication  $schoolApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolApplication $schoolApplication)
    {
        //
    }
}
