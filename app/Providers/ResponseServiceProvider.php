<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = [], $msg = '请求成功') {
            return Response::json([
                'status' => true,
                'msg'=> trim($msg),
                'data' => $data
            ]);
        });

        Response::macro('error', function ($data = [], $error_message = '请求失败',  $sprintf = null) {
            $error_message = $error_message ? trans('errors.'.$error_message) : '未知错误';
            if ($sprintf) {
                $error_message = sprintf($error_message, $sprintf);
            }
            return Response::json([
                    'status' => false,
                    'msg'=> trim($error_message),
                    'data' => $data
                ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
