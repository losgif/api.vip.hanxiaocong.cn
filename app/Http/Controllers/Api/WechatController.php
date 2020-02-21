<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use App\School;
use App\SchoolApplication;
use App\Information;
use EasyWeChat\Kernel\Messages;
use App\Services\UrlSign;

class WechatController extends Controller
{
    use UrlSign;
    
    public function serve(Request $request, School $school)
    {
        $schoolApplications = $school->schoolApplication();
        
        $config = [
            'token' => $school->token
        ];

        $app = Factory::officialAccount($config);

        $app->server->push(function($message) use ($school) {
            try {
                switch ($message['MsgType']) {
                    case 'text':
                        $schoolApplicationKeywords = $school->keyword;
    
                        foreach ($schoolApplicationKeywords as $schoolApplicationKeyword) {
                            $keyword = $schoolApplicationKeyword->keyword;
                            preg_match("/(${keyword})(\d{1,10})/", $message['Content'], $matches);
    
                            if (isset($matches[2])) {
                                $schoolApplicationId = $schoolApplicationKeyword->schoolApplication->id;
                                $schoolApplication = SchoolApplication::where('id', $schoolApplicationId)->first();
                                
                                $id = $matches[2];
    
                                $info = Information::where('school_application_id', $schoolApplicationId)->where('id', $id)->first();
    
                                if ($info) {
                                    $expiredMinutes = 15;
                                    $token = $this->generateToken($expiredMinutes);
    
                                    $title = "点击查看联系方式";
                                    $url = config('app.front_url') . "information/{$info->id}/{$token}/{$schoolApplication->type}";
                                    $description = '您好，感谢您对本栏目的支持，欢迎给自己报名，祝您早日脱单。';
                                    
                                    switch ($schoolApplication->type) {
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
                                continue; // 关键字不匹配跳出循环
                            }
                        }
    
                        return "您好！/玫瑰/玫瑰/玫瑰\n\n欢迎您使用此功能，收到这段话，\n\n可能是因为您操作失误啦!\n\n可以联系平台客服反馈\n\n正确回复方式↓\n\n{$keyword}+编号例如↓\n\n{$keyword}999";
                        break;
                    default:
                        return '收到其他消息';
                        break;
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        });

        return $app->server->serve();
    }
}
