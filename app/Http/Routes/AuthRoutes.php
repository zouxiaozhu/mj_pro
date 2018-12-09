<?php

namespace App\Http\Routes;
use  Illuminate\Support\Facades\Route;
ini_set("error_reporting","E_ALL & ~E_NOTICE");


class AuthRoutes
{
    public function map()
    {
        // 获取登录页面
        Route::group(['middleware' => 'admin.auth'], function () {
            Route::get('/', 'Api\Internal\Service\ViewsController@getHome');
        });

        // view
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Service'], function ($api) {
                    $api->group(['prefix' => 'service'], function ($api) {
                        $api->get('in', 'ViewsController@getLogin');
                        $api->get('home', 'ViewsController@getHome');
                        $api->any('add-member', 'ViewsController@addMember');
                        $api->get('member-list', 'ViewsController@memberList');
                        $api->any('update-member', 'ViewsController@addMember');
                        $api->get('add-order', 'ViewsController@getOrder');
                        $api->get('package', 'ViewsController@packageList');
                        $api->get('add-package/{id?}', 'ViewsController@package');
                        $api->get('order-list', 'ViewsController@orderList');
                    });
                });
            });
        });

        // Auth
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Auth'], function ($api) {
                    $api->group(['prefix' => 'auth'], function ($api) {
                        $api->post('login', 'AuthController@login');  // 用户登录的基本信息
                        $api->get('logout', ['middleware' => 'admin.auth', 'uses' => 'AuthController@logout']); // 用户退出
                        $api->post('create', 'AuthController@create');
                        $api->put('update', 'AuthController@update');
                        $api->get('role', ['middleware' => 'auth', 'uses' => 'RoleController@roleList']);
                        $api->get('mail', ['middleware' => [], 'uses' => 'RoleController@mail']);
                    });
                });
            });


            // member
            $api = app('Dingo\Api\Routing\Router');
            $api->version(env('API_VERSION'), function ($api) {
                $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                    $api->group(['namespace' => 'Member'], function ($api) {
                        $api->group(['prefix' => 'member', 'middleware' => 'admin.auth'], function ($api) {
                            $api->post('add', 'MemberController@addMember' );  // 用户登录的基本信息
                            $api->get('list', 'MemberController@memberList' );  // 用户登录的基本信息
                            $api->get('delete', 'MemberController@delMember' );  // 用户登录的基本信息
                            $api->any('search', 'MemberController@searchUser' );  // 用户登录的基本信息
                        });
                    });
                });
            });


            // package
            $api = app('Dingo\Api\Routing\Router');
            $api->version(env('API_VERSION'), function ($api) {
                $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                    $api->group(['namespace' => 'Package'], function ($api) {
                        $api->group(['prefix' => 'package', 'middleware' => 'admin.auth'], function ($api) {
                            $api->post('add', 'PackageController@addPackage' );
                            $api->get('package', 'PackageController@package' );
                            $api->get('delete', 'PackageController@delPackage' );
                            $api->get('package/{id}', 'PackageController@show' );
                            $api->get('business', 'PackageController@businessType' );
                            $api->get('list', 'PackageController@packageList' );
                        });
                    });
                });
            });

            // order
            $api = app('Dingo\Api\Routing\Router');
            $api->version(env('API_VERSION'), function ($api) {
                $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                    $api->group(['namespace' => 'Order'], function ($api) {
                        // 'admin.auth'
                        $api->group(['prefix' => 'order', 'middleware' => []], function ($api) {
                            $api->post('add', 'OrderController@rechargeOrder');
                            $api->get('list', 'OrderController@orderList');
                            $api->get('count', 'OrderController@count');
                        });
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