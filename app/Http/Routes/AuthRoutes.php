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
                    $api->group(['prefix' => 'auth'], function ($api) {
                        $api->post('login', 'AuthController@login');                                 // 用户登录的基本信息
                        $api->get('logout', 'AuthController@logout');                                // 用户退出
                        $api->get('role', ['middleware' => 'auth', 'uses' => 'RoleController@roleList']);
                        $api->get('mail', ['middleware' => [], 'uses' => 'RoleController@mail']);
                    });
                });
            });


            $api = app('Dingo\Api\Routing\Router');
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Service'], function ($api) {
                    $api->group(['prefix' => 'service'], function ($api) {
                        $api->get('excel', ['uses' => 'ServiceController@createExcel']);
                        $api->get('search', ['uses' => 'XunsearchController@splitWord']);
                    });
                });
            });
        });
    }
}