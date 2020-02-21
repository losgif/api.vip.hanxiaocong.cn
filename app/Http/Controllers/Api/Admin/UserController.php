<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $validator = Validator::make($request->all(), [
            'pageSize' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        try {
            $users = User::orderBy('id', 'desc')->with([
                'role' => function ($r) {
                    $r->with('permission');
                }
            ])->paginate($request->pageSize);

            return $this->success($users);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pageSize' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }
        
        try {
            $users = User::orderBy('id', 'desc')->with([
                'role' => function ($r) {
                    $r->with('permission');
                }
            ])->paginate($request->pageSize);

            return $this->success($users);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore($user->id),],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id),],
            'phone' => ['required', Rule::unique('users')->ignore($user->id),],
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();

        try {
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->status = $request->status;

            $user->save();
            
            DB::commit();

            return $this->success('更新成功');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->failed($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        
        try {
            $user->delete();

            DB::commit();
            
            return $this->success('删除成功');
        } catch (\Throwable $th) {
            DB::rollback();
            
            return $this->failed($th->getMessage());
        }
    }
}
