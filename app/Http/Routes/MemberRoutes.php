<?php
namespace App\Http\Routes;
class MemberRoutes {
    public function map()
    {
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'App\Http\Controllers\Api\External'], function ($api) {
                $api->group(['namespace' => 'Member','perfix'=>'external'], function ($api) {
                    $api->group(['prefix' => 'member'], function ($api) {

                        $api->get('member','MemberController@show');
                        $api->post('login','MemberController@login');
                    });
                });
            });
        });
    }
}