<?php

namespace App\Services;

use Carbon\Carbon;
use Cache;
use Qcloud\Sms\SmsSingleSender;

trait Sms 
{
    public function sendSms($phone)
    {
        try {
            if (empty($phone)) {
                return "手机号码为空";
            }

            $appid = config('sms.appid');
            $appkey = config('sms.appkey');
            $templateId = config('sms.template_id');
            $sign = config('sms.sign');
    
            $code = rand(1111, 9999);
            $expiresMinutes = config('sms.expires_minutes');
            
            $expiresAt = Carbon::now()->addMinutes($expiresMinutes);
            Cache::put($phone, $code, $expiresAt);
    
            $ssender = new SmsSingleSender($appid, $appkey);
            $params = [
                $code, $expiresMinutes
            ];
            $result = $ssender->sendWithParam("86", $phone, $templateId, $params, $sign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
    
            return json_decode($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function verifyCode($phone, $code)
    {
        $phoneCode = Cache::get($phone);

        if (empty($code) or empty($phoneCode)) {
            return false;
        }

        $result = $code == $phoneCode;

        !$result ? : Cache::forget($phone);
        
        return $result;
    }
}