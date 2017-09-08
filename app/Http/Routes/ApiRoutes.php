<?php
namespace App\Http\Routes;

class ApiRoutes
{
    public function map()
    {
        // 获取登录页面
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Member\Controllers'], function ($api) {
                $api->group(['prefix'=>'member'],function ($api) {
                    $api->get('in','MemberController@login');
                    $api->get('register','MemberController@register');
                });
            });
      
        });
    }
}