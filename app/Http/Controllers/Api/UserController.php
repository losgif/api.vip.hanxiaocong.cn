<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\User;
use Symfony\Component\HttpFoundation\Response;

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
            // $user = Auth::user();
            $user = User::where('id', 1)->with([
                'role' => function ($r) {
                    $r->with([
                        'permission' => function ($p) {
                            $p->orderBy('id', 'desc');
                        }
                    ])->orderBy('id', 'desc')->first();
                }
            ])->first();
            
            return $this->success($user);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
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
