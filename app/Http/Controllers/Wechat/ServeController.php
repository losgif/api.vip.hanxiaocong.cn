<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Information;

class ServeController extends Controller
{
    private $app;

    public function __construct()
    {
        $this->app = app('wechat.official_account');
    }

    public function serve()
    {
        $this->app->server->push(function($message) {
            switch ($message['MsgType']) {
                case 'text':
                    preg_match('/(BG)(\d{1,6})/', $message['Content'], $matches);

                    if (isset($matches[2])) {
                        $id = $matches[2];

                        $info = Information::find($id);

                        if ($info) {                            
                            return "您好，感谢您对本栏目的支持\n\n欢迎给自己报名，祝您早日脱单\n\n该选手联系方式↓\n\n" . $info->contact_account; 
                        } else {
                            return '该编号不存在';
                        }

                    }

                    break;
                
                default:
                    break;
            }
        });

        return $this->app->server->serve();
    }
}
