<?php

namespace App\Http\Middleware;

use Closure;

class ChekeAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        return response([
            'code' => 403,
            'message' => '权限不足'
        ], 403);
    }
}
