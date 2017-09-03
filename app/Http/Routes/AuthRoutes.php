<?php

namespace App\Http\Routes;

class AuthRoutes
{
    public function map()
    {
        // 获取登录页面
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Auth'], function ($api) {
                    $api->get('in', 'AuthController@getLogin');

                });
            });
        });
        // Auth
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Auth'], function ($api) {
                    $api->group(['prefix' => 'auth'], function ($api) {
                        $api->post('login', 'AuthController@login');                                 // 用户登录的基本信息
                        $api->get('logout', 'AuthController@logout');// 用户退出

                        $api->post('create', 'AuthController@create');
                        $api->put('update', 'AuthController@update');
                        $api->get('role', ['middleware' => 'auth', 'uses' => 'RoleController@roleList']);
                        $api->get('mail', ['middleware' => [], 'uses' => 'RoleController@mail']);
                    });
                });
            });

            // Service
            $api = app('Dingo\Api\Routing\Router');
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Service'], function ($api) {
                    $api->group(['prefix' => 'service'], function ($api) {
                        $api->get('excel', ['uses' => 'ServiceController@createExcel']);
                        $api->get('search', ['uses' => 'XunsearchController@splitWord']);
                        $api->post('image', ['uses' => 'ImagesController@image']);
                        $api->get('add-water', ['uses' => 'ImagesController@addWater']);
                        $api->post('water', ['uses' => 'ImagesController@uploadWaterPic']);
                    });
                });
            });

        });
    }
}