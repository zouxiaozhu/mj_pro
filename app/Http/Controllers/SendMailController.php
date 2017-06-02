<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
class SendMailController extends Controller
{
    public function mail()
    {   sleep(5);
       $return =  Mail::raw('这是测试数据,发送有'.date("Y-m-d H:i:s").'点击验证',function($message){
            $message->subject('厚建测试111');
            $message->to('1428804176@qq.com','这是测试数据,发送有'.date("Y-m-d H:i:s").'点击验证');
        });

    }

}
