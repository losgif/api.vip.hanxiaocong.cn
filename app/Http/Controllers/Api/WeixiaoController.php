<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\ActiveApplication;
use App\Jobs\CloseApplication;
use App\Jobs\UpdateKeyword;
use App\Services\Weixiao;
use App\Services\UrlSign;
use App\School;
use App\ApplicationPlatform;
use App\Information;
use EasyWeChat\Kernel\Messages;

class WeixiaoController extends Controller
{
    use Weixiao, UrlSign;
    
    /**
     * 微校入口函数
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, $apiKey = null)
    {
        $type = $request->type;

        $parameters = $request->all();
        unset($parameters['type']);
        unset($parameters['s']);

        if ($apiKey) {
            $parameters['api_key'] = $apiKey;
        }

        switch ($type) {
            case 'open':
                return $this->handleOpen();
                break;
            case 'config':
                return $this->handleConfig($parameters);
                break;
            case 'trigger':
                return $this->handleTrigger($parameters);
                break;
            case 'keyword':
                return $this->handleKeyword();
                break;
            case 'close':
                return $this->handleClose();
                break;
            case 'monitor':
                return $this->handleMonitor();
                break;
            default:
                break;
        }
    }

    /**
     * 处理应用关闭函数
     *
     * @return Response
     */
    public function handleClose()
    {
        $post_data = file_get_contents('php://input');
        $data = json_decode($post_data, true);
        $sign = $data['sign'];
        
        $result = $this->validatorSign($data, $sign);

        if ($result) {
            CloseApplication::dispatchNow($data);

            $response = [
                'errcode' => 0,
                'errmsg' => 'OK'
            ];
        } else {
            $response = [
                'errcode' => 500,
                'errmsg' => '验签失败'
            ];
        }

        return json_encode($response);
    }
    
    /**
     * 应用监控函数
     *
     * @return string
     */
    public function handleMonitor()
    {
        $post_data = file_get_contents('php://input');
        $data = json_decode($post_data, true);

        return $data['echostr'];
    }

    /**
     * 处理应用触发事件
     *
     * @param array $parameters
     * @return Message
     */
    public function handleTrigger($parameters)
    {
        $school = School::where('media_id', $parameters['media_id'])->first();

        $applicationPlatform = ApplicationPlatform::where('key', $parameters['api_key'])->where(['type' => 'weixiao'])->first();
        $application = $applicationPlatform->application;

        $schoolapplication = $school->schoolApplication()->where('application_id', $application->id)->orderBy('id', 'desc')->first();

        if (!empty($school)) {
            $app = app('wechat.official_account');
            $app->server->push(function ($message) use ($school, $application, $schoolapplication) {
                switch ($message['MsgType']) {
                    case 'text':
                        $schookKeywords = $school->keyword;

                        foreach ($schookKeywords as $item) {
                            $keyword = $item->keyword;
                            preg_match("/(${keyword})(\d{1,10})/", $message['Content'], $matches);

                            if (isset($matches[2])) {
                                $id = $matches[2];
    
                                $info = $schoolapplication->information()->where('id', $id)->first();
    
                                if ($info) {
                                    $expiredMinutes = 15;
                                    $token = $this->generateToken($expiredMinutes);

                                    $title = "点击查看联系方式";
                                    $url = config('app.front_url') . "/information/{$info->id}/{$token}/{$application->type}";
                                    $description = '您好，感谢您对本栏目的支持，欢迎给自己报名，祝您早日脱单。';
                                    
                                    switch ($application->type) {
                                        case 'goddess':
                                            $image = $info->extra->person_image;
                                            break;

                                        case 'roommate':
                                            $image = $info->extra->person_image;
                                            break;

                                        default:
                                            $image = $info->extra->person_image;
                                            break;
                                    }
        
                                    $items = [
                                        new Messages\NewsItem([
                                            'title'       => $title,
                                            'description' => $description,
                                            'url'         => $url,
                                            'image'       => $image
                                        ]),
                                    ];
        
                                    $news = new Messages\News($items);

                                    return $news;
                                } else {
                                    return '该编号不存在';
                                }
    
                            } else {
                                continue; //关键字不匹配跳出循环
                            }
                        }

                        return "您好！/玫瑰/玫瑰/玫瑰\n\n欢迎您使用此功能，收到这段话，\n\n可能是因为您操作失误啦!\n\n可以联系平台客服反馈\n\n正确回复方式↓\n\n{$keyword}+编号例如↓\n\n{$keyword}999";
                        break;
                    default:
                        return '收到其他消息';
                        break;
                }
            });
            
            $response = $app->server->serve();

            return $response;
        } else {
            ActiveApplication::dispatchNow($parameters);
        }
    }

    /**
     * 处理关键字修改时间
     *
     * @return Response
     */
    public function handleKeyword()
    {
        $post_data = file_get_contents('php://input');
        $data = json_decode($post_data, true);
        $sign = $data['sign'];
        
        $result = $this->validatorSign($data, $sign);

        if ($result) {
            UpdateKeyword::dispatchNow($data, $data['keyword']);

            $response = [
                'errcode' => 0,
                'errmsg' => 'OK'
            ];
        } else {
            $response = [
                'errcode' => 500,
                'errmsg' => '验签失败'
            ];
        }

        return json_encode($response);
    }

    /**
     * 应用配置页面处理函数
     *
     * @param array $parameters
     * @return Response
     */
    public function handleConfig($parameters)
    {
        $sign = $parameters['sign'];
        $result = $this->validatorSign($parameters, $sign, true);

        if ($result) {
            $mediaId = $parameters['media_id'];

            $school = School::where('media_id', $mediaId)->first();
            $user = $school->user;

            if (empty($user)) {
                return redirect(config('app.front_url') . '/403');
            } else {
                $applicationPlatform = ApplicationPlatform::where('key', $parameters['api_key'])->where(['type' => 'weixiao'])->first();
                $application = $applicationPlatform->application;

                $schoolapplication = $user->application()->where('application_id', $application->id)->orderBy('id', 'desc')->first();

                $redirectUrl = \urlencode("/weixiao/{$schoolapplication->type}/{$schoolapplication->id}");
                
                $url = config('app.front_url') . "/user/login?redirect=${redirectUrl}&access_token=" . $user->createToken('AccessToken')->accessToken;
                return redirect($url);
            }
        } else {
            return redirect(config('app.front_url') . '/500');
        }
    }

    /**
     * 处理开启应用事件
     *
     * @return json
     */
    public function handleOpen()
    {
        $post_data = file_get_contents('php://input');
        $data = json_decode($post_data, true);
        $sign = $data['sign'];
            
        $result = $this->validatorSign($data, $sign);

        if ($result) {
            ActiveApplication::dispatchNow($data);
            
            $response = [
                'errcode' => 0,
                'errmsg' => 'OK',
                'token' => 'wechat',
                'is_config' => 1
            ];
        } else {
            $response = [
                'errcode' => 500,
                'is_config' => 1
            ];
        }

        return json_encode($response);
    }
}
