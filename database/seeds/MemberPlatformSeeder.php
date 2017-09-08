<?php

use Illuminate\Database\Seeder;

use MXU\Member\Models\MemberPlatform;

class MemberPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platforms = [
            [
                'name' => 'QQ',
                'brief' => '使用QQ登录注册',
                'sign' => 'qq',
            ],
            [
                'name' => '微博',
                'brief' => '使用微博登录注册',
                'sign' => 'sina',
            ],
            [
                'name' => '微信',
                'brief' => '使用微信登录注册',
                'sign' => 'wechat',
            ],
            [
                'name' => '手机',
                'brief' => '使用手机登录注册',
                'sign' => 'mobile',
            ],
            [
                'name' => '邮箱',
                'brief' => '使用邮箱登录注册',
                'sign' => 'email',
            ],
            [
                'name' => 'SSO',
                'brief' => '使用SSO登录注册',
                'sign' => 'web',
            ],
            [
                'name' => '普通会员',
                'brief' => '使用普通会员',
                'sign' => 'mxu',
            ],
        ];

        if (!MemberPlatform::all()->count()) {
            foreach ($platforms as $platform) {
                MemberPlatform::create($platform);
            }
        }
    }
}
