<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
class SendMailController extends Controller
{
    public function mail()
    {
       $return =  Mail::raw('cesssss111',function($message){
            $message->subject('厚建测试111');
            $message->to('1428804176@qq.com','s11111111adsasdasdas');
        });

    }

}
