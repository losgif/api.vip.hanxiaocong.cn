<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Kernel\Messages\Text;
use App\Info;

class ServeController extends Controller
{
    private $app;

    public function __construct()
    {
        $this->app = app('wechat.official_account');
    }

    public function serve()
    {
        $this->app->server->push(function($message){
            switch ($message['MsgType']) {
                case 'text':
                    
                    preg_match('/(love)(\d{1,6})/', $message['Content'], $matches);

                    if (isset($matches[2])) {
                        $id = $matches[2];

                        $info = Info::find($id);

                        if ($info) {
                            return "您好，感谢您对本栏目的支持\n\n欢迎给自己报名，祝您早日脱单\n\n该选手联系方式↓\n\n" . $info->ta_tel; 
                        } else {
                            return '该编号不存在';
                        }

                    } else {
                        return "您好！/玫瑰/玫瑰/玫瑰\n\n欢迎您使用此功能，收到这段话，\n\n可能是因为您操作失误啦!\n\n可以联系平台客服反馈\n\n正确回复方式↓\n\nlove+编号例如↓\n\nlove999";
                    }

                    break;
                
                default:
                    # code...
                    return "您好！/玫瑰/玫瑰/玫瑰\n\n欢迎您使用此功能，收到这段话，\n\n可能是因为您操作失误啦!\n\n可以联系平台客服反馈\n\n正确回复方式↓\n\nlove+编号例如↓\n\nlove999";

                    break;
            }
        });

        return $this->app->server->serve();
    }
}
