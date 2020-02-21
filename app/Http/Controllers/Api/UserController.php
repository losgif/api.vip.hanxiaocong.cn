<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Illuminate\Validation\Rule;
use Hash;

class UserController extends Controller
{
    /**
     * 注册权限
     *
     * @param Request $request
     * @return Response
     */
    public function assignRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();

        try {
            $user = User::where('id', $request->user_id)->first();
            $role = Role::find($request->role_id);

            $user->assignRole($role);
            $user->save();

            DB::commit();

            return $this->success('绑定成功');
        } catch (\Exception $e) {
            DB::rollback();

            return $this->failed($e->getMessage());
        }
    }

    /**
     * 获取用户信息
     *
     * @param Request $request
     * @return Response
     */
    public function getInfo(Request $request)
    {
        try {
            $user = Auth::user();
            $user = User::where('id', $user->id)->with(['role' => function($r) {
                $r->with('permission');
            }])->first();
            
            return $this->success($user);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'  => ['required', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', Rule::unique('users')->ignore($user->id)],
            'password' => ['sometimes']
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if (isset($request->password) && !empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();

            return $this->success('更新成功');
        } catch (\Exception $e) {
            DB::rollback();

            return $this->failed($e->getMessage());
        }
    }

    /**
     * 用户搜索
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = new User();

            $user = $user->where('phone', 'like', "%$request->q%")->get();

            return $this->success($user);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());            
        }
    }
}
