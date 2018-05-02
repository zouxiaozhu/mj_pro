<?php

namespace App\Http\Routes;

class IndexRoutes
{
    public function map()
    {
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Index'], function ($api) {
                    $api->group(['prefix' => 'index'], function ($api) {
                        $api->get('admin','IndexController@userInfo');
                    });

                });
            });
        });
    }
}