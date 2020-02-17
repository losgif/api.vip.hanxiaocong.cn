<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\ApplicationPlatform;

trait Weixiao 
{
    /**
     * 腾讯微校API请求地址
     *
     * @var string
     */
    private $API_URL = "https://weixiao.qq.com/apps/v1/data/media-info";

    /**
     * 获取公众号信息
     *
     * @param string $mediaId
     * @return array
     */
    public function getWeixiaoInfo($mediaId, $applicationKey, $applicationSecret)
    {
        $client = new Client();

        $parameters = [
            'media_id' => $mediaId,
            'api_key' => $applicationKey,
            'timestamp' => time(),
            'nonce_str' => Str::random(32),
        ];

        $parameters['sign'] = $this->sign($parameters, $applicationSecret);
        
        $response = $client->post($this->API_URL, [
            'json' => $parameters
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * 验签函数
     *
     * @param array $parameters
     * @param string $sign
     * @return bool
     */
    private function validatorSign($parameters, $sign, $isConfig = false)
    {
        return $this->sign($parameters, null, $isConfig) == $sign;
    }

    /**
     * 签名函数
     *
     * @param array $parameters
     * @return bool
     */
    private function sign($parameters, $applicationSecret = null, $isConfig = false)
    {
        if (empty($applicationSecret)) {
            $applicationPlatform = ApplicationPlatform::where('key', $parameters['api_key'])->where(['type' => 'weixiao'])->first();            
            $applicationSecret = $applicationPlatform->secret;
        }

        /**
         * 删除不参与验签参数
         */
        unset($parameters['sign']);
        unset($parameters['signature']);
        unset($parameters['keyword']);
        if ($isConfig) {
            unset($parameters['api_key']);
        }

        ksort($parameters);

        $string = http_build_query($parameters);
        $string .= '&key=' . $applicationSecret;
        $string = md5($string);
        $string = strtoupper($string);

        return $string;
    }
}