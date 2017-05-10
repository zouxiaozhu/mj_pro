<?php
/**
 * Created by PhpStorm.
 * User: jiuji
 * Date: 2017/5/10
 * Time: 上午9:17
 */
namespace App\Http\Routes;
class AuthRoutes{
    public function map(){
        $api = app('Dingo\Api\Routing\Router');
        $api->version(env('API_VERSION'), function ($api) {
            $api->group(['namespace' => 'MXU\Http\Controllers\Api\Internal'], function ($api) {
                $api->group(['namespace' => 'Advertisement'], function ($api) {
                    $api->group(['prefix' => 'advertisement', 'middleware' => ['m2o.auth', 'prms.get']], function ($api) {
                        $api->get('adv', 'AdvertisementController@getAdvList');                        // 获取广告列表
                        $api->get('detail/{id}', 'AdvertisementController@getAdvDetail');              // 获取广告信息详情
                        $api->post('adv', 'AdvertisementController@createNewAdv');                     // 新增广告
                        $api->put('adv', 'AdvertisementController@updateAdv');                         // 更新广告
                        $api->delete('adv/{id}', 'AdvertisementController@deleteAdv');                 // 删除广告
                        $api->put('sold-out/{ids}', 'AdvertisementController@soldOutAdv');             // 广告下架
                        $api->get('group-position', 'AdvertisementController@getGroupPosition');       // 获取广告位分组与广告位关联数据
                        $api->get('position', 'AdvertisementController@getAdvPosition');               // 获取广告位置
                        $api->get('group', 'AdvertisementController@getAdvGroup');                     // 获取广告位分组
                        $api->post('upload', 'AdvertisementController@uploadAdvMaterial');             // 物料(附件)上传
                        $api->post('materials', 'AdvertisementController@createAdvMaterial');          // 新增物料信息
                        $api->put('materials', 'AdvertisementController@updateAdvMaterial');           // 更新物料信息
                        $api->delete('materials/{id}', 'AdvertisementController@delAdvMaterial');      // 删除物料信息
                        $api->get('materials/{id}', 'AdvertisementController@materialDetail');         // 获取物料信息详情
                    });
                });
            });
        });



    }


}