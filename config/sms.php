<?php
return [
    'appid' => env('QCLOUD_SMS_APP_ID'),
    'appkey' => env('QCLOUD_SMS_APP_KEY'),
    'template_id' => env('QCLOUD_SMS_TEMPLATE_ID'),
    'sign' => env('QCLOUD_SMS_SIGN'),
    'expires_minutes' => env('QCLOUD_SMS_EXPIRES_MINUTES', 10)
];