<?php

namespace App\Services;

use Illuminate\Support\Str;
use Cache;

trait UrlSign 
{   
    /**
     * 签名函数
     *
     * @param string $expiredMinutes
     * @return bool
     */
    private function generateToken($expiredMinutes = 10)
    {
        $token = Str::random(64);
        Cache::put($token, true, now()->addMinutes($expiredMinutes));

        return $token;
    }

    /**
     * 验证签名函数
     *
     * @param string $token
     * @return bool
     */
    private function validateToken($token)
    {
        if (Cache::get($token)) {
            Cache::forget($token);

            return true;
        } else {
            return false;
        }
    }
}