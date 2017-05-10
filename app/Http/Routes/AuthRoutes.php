<?php

namespace App\Http\Routes;

class AuthRoutes
{
    public function map()
    {

        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Auth'], function ($api) {
                    $api->group(['prefix' => 'adv'], function ($api) {
                        $api->get('adv', 'AuthController@index');                        // 获取广告列表


                    });
                });
            });
        });
    }
}