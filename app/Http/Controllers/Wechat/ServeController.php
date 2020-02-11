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
                            return " 济南大学助手竭诚为您服务\n\n/玫瑰/玫瑰/玫瑰<a href='http://maisheyou.mreex.com/'>点击卖舍友</a> /玫瑰/玫瑰/玫瑰\n\n回复：教务，进入微信教务系统\n可以查询成绩、课表、自习室等\n\n济南大学助手提供该嘉宾\n联系方式：" . $info->ta_tel; 
                        } else {
                            return '该编号不存在';
                        }

                    } else {
                        return "您好！欢迎您使用济南大学助手卖舍友功能，收到这段话，可能是因为您操作失误啦!";
                    }

                    break;
                
                default:
                    # code...
                    return "您好！欢迎您使用济南大学助手卖舍友功能，收到这段话，可能是因为您操作失误啦!";

                    break;
            }
        });

        return $this->app->server->serve();
    }
}
