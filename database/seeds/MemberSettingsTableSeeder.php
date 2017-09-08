<?php

use Illuminate\Database\Seeder;
use MXU\Member\Models\Settings;

class MemberSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->member_settings();
    }

    public function member_settings()
    {
        $sets = [
            [
                'group'       => 'register',
                'name'        => '是否填写邮箱',
                'description' => '',
                'key'         => 'is_email',
                'value'       => 0,
            ],
            [
                'group'       => 'foot',
                'name'        => '会员中心联系电话',
                'description' => '',
                'key'         => 'tel',
                'value'       => '',
            ],
            [
                'group'       => 'register',
                'name'        => '是否填写手机',
                'description' => '',
                'key'         => 'is_mobile',
                'value'       => 0,
            ],
            [
                'group'       => 'foot',
                'name'        => '会员中心备案号',
                'description' => '',
                'key'         => 'icp',
                'value'       => '',
            ],
            [
                'group'       => 'foot',
                'name'        => '会员中心版权',
                'description' => '',
                'key'         => 'copyright',
                'value'       => '',
            ],
            [
                'group'       => 'login',
                'name'        => '新浪微博登陆',
                'description' => '',
                'key'         => 'sina_login',
                'value'       => 0,
            ],
            [
                'group'       => 'login',
                'name'        => '腾讯QQ登陆',
                'description' => '',
                'key'         => 'qq_login',
                'value'       => 0,
            ],
            [
                'group'       => 'qq',
                'name'        => 'APPID',
                'description' => '腾讯',
                'key'         => 'appid',
                'value'       => '',
            ],
            [
                'group'       => 'sina',
                'name'        => 'APPID',
                'description' => '新浪',
                'key'         => 'appid',
                'value'       => '',
            ],
            [
                'group'       => 'sina',
                'name'        => 'APPKEY',
                'description' => '新浪',
                'key'         => 'appkey',
                'value'       => '',
            ],
            [
                'group'       => 'qq',
                'name'        => 'APPKEY',
                'description' => '腾讯',
                'key'         => 'appkey',
                'value'       => '',
            ],
            [
                'group'       => 'login',
                'name'        => 'cookie域名',
                'description' => '会员登陆',
                'key'         => 'cookie_domain',
                'value'       => '.',
            ],
            [
                'group'       => 'qq',
                'name'        => '登陆回调接口',
                'description' => '腾讯',
                'key'         => 'callback',
                'value'       => '',
            ],
            [
                'group'       => 'sina',
                'name'        => '登陆回调接口',
                'description' => '新浪',
                'key'         => 'callback',
                'value'       => '',
            ],
            [
                'group'       => 'sina',
                'name'        => '接口名称',
                'description' => '新浪',
                'key'         => 'auth_name',
                'value'       => 'Sina weibo',
            ],
            [
                'group'       => 'qq',
                'name'        => '接口名称',
                'description' => '腾讯',
                'key'         => 'auth_name',
                'value'       => 'Tencent QQ',
            ],
            [
                'group'       => 'qq',
                'name'        => 'AUTH网址',
                'description' => '腾讯',
                'key'         => 'auth_url',
                'value'       => '',
            ],
            [
                'group'       => 'sina',
                'name'        => 'AUTH网址',
                'description' => '新浪',
                'key'         => 'auth_url',
                'value'       => '',
            ],
            [
                'group'       => 'login',
                'name'        => 'cookie路径',
                'description' => '会员登陆',
                'key'         => 'cookie_path',
                'value'       => '/',
            ],
            [
                'group'       => 'qq',
                'name'        => 'AUTH图标',
                'description' => '腾讯',
                'key'         => 'auth_img',
                'value'       => '',
            ],
            [
                'group'       => 'sina',
                'name'        => 'AUTH图标',
                'description' => '新浪',
                'key'         => 'auth_img',
                'value'       => '',
            ],
            [
                'group'       => 'login',
                'name'        => 'cookie有效期',
                'description' => '会员登陆',
                'key'         => 'cookie_expire',
                'value'       => 3600,
            ],
            [
                'group'       => 'head',
                'name'        => 'LOGO',
                'description' => '',
                'key'         => 'logo',
                'value'       => '',
            ],
            [
                'group'       => 'head',
                'name'        => '会员管理中心标题',
                'description' => '',
                'key'         => 'title',
                'value'       => '会员管理中心',
            ],
            [
                'group'       => 'head',
                'name'        => '会员中心banner名称',
                'description' => '',
                'key'         => 'banner_name',
                'value'       => '会员中心',
            ],
            [
                'group'       => 'navigate',
                'name'        => '首页',
                'description' => '',
                'key'         => 'home',
                'value'       => '',
            ],
            [
                'group'       => 'head',
                'name'        => '会员中心描述',
                'description' => '',
                'key'         => 'description',
                'value'       => '我是会员中心',
            ],
            [
                'group'       => 'foot',
                'name'        => '会员中心版权',
                'description' => '',
                'key'         => 'copyright',
                'value'       => 'Hoge.cn',
            ],
            [
                'group'       => 'head',
                'name'        => '会员标题连接符',
                'description' => '例如:会员中心｛连接符｝登陆',
                'key'         => 'connector',
                'value'       => '-',
            ],
            [
                'group'       => 'forget',
                'name'        => '找回方式',
                'description' => '',
                'key'         => 'type',
                'value'       => 'mobile',
            ],
            [
                'group'       => 'login',
                'name'        => '登陆默认跳转地址',
                'description' => '',
                'key'         => 'redirect',
                'value'       => 'http://sso.{{DOMAIN}}/',
            ],
            [
                'group'       => 'register',
                'name'        => '是否需要验证码',
                'description' => '此项为图片验证码,设置后需要到会员后台启用接口验证！',
                'key'         => 'is_verify_code',
                'value'       => 0,
            ],
            [
                'group'       => 'base',
                'name'        => '上传附件类型设置',
                'description' => '上传附件类型设置，中间英文逗号隔开 例如：.jpg,.png,.gif,.jpeg',
                'key'         => 'material_type',
                'value'       => '.jpg,.png,.gif,.jpeg',
            ],
            [
                'group'       => 'base',
                'name'        => '上传视频音频格式限制',
                'description' => '上传视频音频格式限制,例如：.wmv,.avi,',
                'key'         => 'media_type',
                'value'       => '.wmv,.avi,.rmvb,.mp4,.flv,.mp3,.vob,.aac,.amr,.ts',
            ],
            [
                'group'       => 'forget',
                'name'        => '是否开启密码找回',
                'description' => '开启密码找回功能',
                'key'         => 'find_password',
                'value'       => 1,
            ],
            [
                'group'       => 'forget',
                'name'        => '是否需要验证码',
                'description' => '此项为图片验证码,设置后需要到会员后台启用接口验证！',
                'key'         => 'is_verify_code',
                'value'       => 0,
            ],
            [
                'group'       => 'register',
                'name'        => '是否填写手机验证码',
                'description' => '',
                'key'         => 'is_mobile_verify_code',
                'value'       => 0,
            ],
            [
                'group'       => 'qq',
                'name'        => '腾讯QQ调试模式',
                'description' => '',
                'key'         => 'debug',
                'value'       => 0,
            ],
            [
                'group'       => 'register',
                'name'        => '是否填写邮箱验证码',
                'description' => '',
                'key'         => 'is_email_verify_code',
                'value'       => 0,
            ],
            [
                'group'       => 'register',
                'name'        => '注册功能',
                'description' => '会员中心注册功能管理，此处配置完成后仅仅禁止会员中心注册页报错，如需禁止会员应用接口，还需进入会员应用配置。',
                'key'         => 'register',
                'value'       => 1,
            ],
            [
                'group'       => 'qq',
                'name'        => '请求授权列表',
                'description' => '值参照腾讯授权列表文档，多个以 英文 逗号 分割',
                'key'         => 'scope',
                'value'       => '',
            ],
            [
                'group'       => 'login',
                'name'        => '普通登陆',
                'description' => '普通登陆功能管理。',
                'key'         => 'login',
                'value'       => 1,
            ],
            [
                'group'       => 'sms',
                'name'        => '短信服务器',
                'description' => '是否启用短信服务器',
                'key'         => 'is_open',
                'value'       => 1,
            ],
            [
                'group'       => 'sms',
                'name'        => '每个手机号每天限制请求短信次数',
                'description' => '每个手机号每天限制请求短信次数',
                'key'         => 'daily_limit',
                'value'       => 50,
            ],
        ];
        foreach ($sets as $set) {
            if (!Settings::where(['group' => $set['group'], 'key' => $set['key']])->count()) {
                Settings::create($set);
            }
        }
    }
}
