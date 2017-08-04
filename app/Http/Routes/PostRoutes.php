<?php

namespace App\Http\Routes;

class PostRoutes
{
    public function map()
    {
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Post'], function ($api) {
                    $api->group(['prefix' => 'post'], function ($api) {
                        $api->get('test','PostController@test');
                    });

                });
            });
        });
    }
}