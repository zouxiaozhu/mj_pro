<?php

namespace App\Http\Routes;

class PostRoutes
{
    public function map()
    {
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
//            // 对外
//            $api->group(['namespace' => 'App\Http\Controllers\Api\External'], function ($api) {
//                $api->group(['namespace' => 'Post','prefix' => 'external'], function ($api) {
//                    $api->group(['prefix' => 'post'], function ($api) {
//                        $api->post('post','PostController@create');
//                    });
//                });
//            });
            // 对内
            $api->group(['namespace' => 'App\Post\Controllers'], function ($api) {
                $api->group(['prefix' => 'post'], function ($api) {
                    $api->get('post', 'PostController@show');
                    $api->post('post', 'PostController@create');
                    $api->put('post', 'PostController@update');
                    $api->delete('post', 'PostController@delete');
                });
            });

            $api->group(['namespace' => 'App\Post\Controllers'], function ($api) {
                $api->group(['prefix' => 'post'], function ($api) {
                    $api->get('forum', 'ForumController@show');
                    $api->post('forum', 'ForumController@create');
                    $api->put('forum', 'ForumController@update');
                    $api->delete('forum', 'ForumController@delete');
                });
            });





        });
    }
}