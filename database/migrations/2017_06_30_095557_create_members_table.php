<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 会员主表
        $this->create_member_members_table();
        // 会员分组表
        $this->create_member_group_table();
        // 会员详情表
        $this->create_member_info_table();
        // 会员绑定表(手机,邮箱,第三方)
        $this->create_member_bind_table();
        // 会员痕迹表
        $this->create_member_trace_table();
        // 积分规则表
        $this->create_member_credit_rules_table();
        // 积分类型表
        $this->create_member_credit_types_table();
        // 积分日志表
        $this->create_member_credit_logs_table();
        // 短信服务器表
        $this->create_member_sms_server_table();
        // 存储验证码
        $this->create_member_sms_verify_table();
        // 短信日志
        $this->create_member_sms_log_table();
        // 短信总数
        $this->create_member_sms_count_table();
        // 会员相关设置
        $this->create_member_settings_table();
        // 会员登录表
        $this->create_member_sessions_table();
        // 平台表
        $this->create_member_platforms_table();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop_member_members_table();
        $this->drop_member_group_table();
        $this->drop_member_info_table();
        $this->drop_member_bind_table();
        $this->drop_member_trace_table();
        $this->drop_member_credit_rules_table();
        $this->drop_member_credit_types_table();
        $this->drop_member_credit_logs_table();
        $this->drop_member_sms_server_table();
        $this->drop_member_sms_verify_table();
        $this->drop_member_sms_log_table();
        $this->drop_member_sms_count_table();
        $this->drop_member_settings_table();
        $this->drop_member_sessions_table();
        $this->drop_member_platforms_table();
    }

    /**
     * 会员主表
     */
    public function create_member_members_table()
    {
        Schema::create('member_members', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('member_name')->comment('会员名');
            $table->string('nick_name')->comment('昵称')->default('');
            $table->string('password');
            $table->string('type')->comment('会员类型');
            $table->tinyInteger('group_id')->comment('会员分组id')->default(0)->unsigned()->index();
            $table->string('avatar')->comment('头像')->default('');
            $table->integer('credits')->comment('会员总积分');
            $table->integer('exp_points')->comment('会员总经验');
            $table->integer('frozen_credit')->comment('冻结积分')->default(0);
            $table->string('signature')->comment('个性签名')->default('');
            $table->string('email')->comment('邮箱')->nullable()->unique();
            $table->string('mobile')->comment('手机')->unique()->nullable();
            $table->enum('status', [0, 1])->comment('状态，0禁用，1活跃')->default(1)->index();
            $table->enum('is_verify', [0, 1])->comment('状态，0未认证，1已认证')->default(0)->index();
            $table->string('ip')->comment('注册IP')->default('');
            $table->string('last_login_ip')->comment('最后登录IP')->default('');
            $table->string('push_device')->comment('推送设备号')->default('');
            $table->string('reg_device')->comment('注册设备号')->default('');
            $table->string('last_login_device')->comment('最后一次登录设备号')->default('');
            $table->string('last_push_device')->comment('最后一次登录推送号')->default('');
            $table->string('reg_device_type')->comment('注册设备ios,web,android')->index()->default('');
            $table->string('last_login_device_type')->comment('登录设备ios,web,android')->index()->default('');
//            $table->string('final_login_time')->comment('上次登陆时间');
            $table->string('last_login_time')->comment('最后登陆时间')->default('');
            $table->integer('user_id')->default(0);
            $table->integer('referee_id')->nullable()->comment('推荐人ID')->default(0);
            $table->integer('site_id')->comment('站点id')->index()->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function drop_member_members_table()
    {
        Schema::dropIfExists('member_members');
    }

    /**
     * 会员分组表
     */
    public function create_member_group_table()
    {
        Schema::create('member_groups', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('group_name')->comment('分组名')->unique();
            $table->enum('is_system', [0, 1])->comment('是否系统组，0否，1是')->index()->default(0);
            $table->enum('type', [0, 1, 2])->comment('分组类型，0积分制，1授予，2购买')->index()->default(0);
            $table->integer('exp_top')->comment('升级上限')->default(0);
            $table->integer('exp_down')->comment('升级下限')->default(0);
            $table->tinyInteger('star_num')->comment('星星数')->index()->unsigned()->default(0);
            $table->string('color', 7)->comment('会员名颜色')->default('#000000');
            $table->string('icon')->comment('会员组icon')->nullable()->default('');
            $table->string('description')->comment('简介')->nullable()->default('');
            $table->enum('status', [0, 1])->comment('展示状态，0不展示，1展示')->index()->default(1);
            $table->integer('order_id')->comment('排序id')->index();
            $table->integer('site_id')->comment('站点id')->index();
            $table->timestamps();
        });
    }

    public function drop_member_group_table()
    {
        Schema::dropIfExists('member_groups');
    }

    /**
     * 会员详情表
     */
    public function create_member_info_table()
    {
        Schema::create('member_info', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('member_id');
            $table->string('province')->comment('省')->default('');
            $table->string('city')->comment('市')->default('');
            $table->string('dist')->comment('区')->default('');
            $table->string('detail')->comment('详细信息')->default('');
            $table->string('wechat')->comment('微信')->default('');
            $table->string('qq')->comment('qq')->default('');
            $table->string('birthday')->comment('生日年')->default('');
            $table->enum('gender', [0, 1, 2])->comment('性别，0保密，1男, 2女')->index()->default(0);
            $table->timestamps();
        });
    }

    public function drop_member_info_table()
    {
        Schema::dropIfExists('member_info');
    }

    /**
     * 会员绑定表
     */
    public function create_member_bind_table()
    {
        Schema::create('member_bind', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->integer('member_id')->comment('会员id')->index();
            $table->string('platform_id')->index()->comment('第三方平台会员id(手机号)');
            $table->string('third_name')->comment('第三方用户名')->default('');
            $table->string('avatar_url')->comment('头像地址')->default('');
            $table->string('type')->comment('会员类型(来源)')->index();
            $table->string('type_name')->comment('会员类型名称(来源)');
            $table->string('ip')->comment('绑定IP');
            $table->string('bind_device_token')->comment('绑定设备号')->default('');
            $table->timestamps();
        });
    }

    public function drop_member_bind_table()
    {
        Schema::dropIfExists('member_bind');
    }

    /**
     * 会员操作痕迹表
     */
    public function create_member_trace_table()
    {
        Schema::create('member_trace', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->integer('member_id')->index()->comment('会员id');
            $table->string('member_name')->comment('操作人会员名')->index();
            $table->integer('user_id')->index()->comment('操作用户id')->default(0);
            $table->string('type')->comment('操作类型')->index();
            $table->string('type_name')->comment('操作名称');
            $table->string('ip')->comment('创建IP')->default('');
            $table->string('device_token')->comment('创建device_token')->default('');
            $table->timestamps();
        });
    }

    public function drop_member_trace_table()
    {
        Schema::dropIfExists('member_trace');
    }

    /**
     * 积分规则主表
     */
    public function create_member_credit_rules_table()
    {
        Schema::create('member_credit_rules', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('rule_name')->unique()->comment('积分规则名称');
            $table->string('operation')->unique()->comment('积分任务操作标识');
            $table->enum('is_system', [0, 1])->comment('是否系统默认，0否，1是')->index()->default(0);
            $table->enum('is_custom', [0, 1])->comment('是否允许自定义积分规则，0否，1是')->default(0)->index();
            $table->enum('status', [0, 1])->comment('是否启用，0否，1是')->default(1)->index();
            $table->integer('rule_level')->comment('积分规则级别')->default(0);
            $table->enum('rule_type', [0, 1, 2, 3, 4])->comment('时间类型,奖励周期0:一次;1:每天;2:整点;3:间隔分钟;4:不限;')->default(0)->index();
            $table->integer('rule_times')->comment('规则启动间隔时间')->default(0);
            $table->tinyInteger('rule_num')->comment('规则使用次数,0为不限')->unsigned()->default(1);
            $table->integer('credits')->comment('积分')->default(0);
            $table->integer('exp_points')->comment('金币/经验')->default(0);
            $table->string('rule_detail')->comment('扣除或奖励积分详情');
            $table->integer('order_id')->comment('排序id')->index();
            $table->string('rule_introduce')->comment('积分任务说明');
            $table->enum('app_status', [0, 1])->comment('app端是否可见，0否，1是')->default(1)->index();
            $table->timestamps();
        });
    }

    public function drop_member_credit_rules_table()
    {
        Schema::dropIfExists('member_credit_rules');
    }

    /**
     * 积分类型(金币,积分)
     */
    public function create_member_credit_types_table()
    {
        Schema::create('member_credit_types', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('type_name')->unique()->comment('类型名称');
            $table->string('db_field')->unique()->comment('所在字段');
            $table->enum('is_on', [0, 1])->comment('是否开启，0否，1是')->default(1)->index();
            $table->enum('is_trans', [0, 1])->comment('是否允许交易，0否，1是')->default(0)->index();
            $table->enum('is_update', [0, 1])->comment('是否为等级积分类型，0否，1是')->default(0)->index();
            $table->timestamps();
        });
    }

    public function drop_member_credit_types_table()
    {
        Schema::dropIfExists('member_credit_types');
    }

    /**
     * 积分日志
     */
    public function create_member_credit_logs_table()
    {
        Schema::create('member_credit_logs', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->integer('member_id')->index()->comment('会员id');
            $table->integer('user_id')->index()->comment('管理员id')->default(0);
            $table->integer('rule_id')->index()->comment('积分规则id');
            $table->string('operation')->comment('操作标识');
            $table->integer('credits')->comment('积分变化')->default(0);
            $table->integer('exp_points')->comment('经验变化')->default(0);
            $table->string('log_title')->comment('日志标题');
            $table->string('log_detail')->comment('日志内容');
            $table->string('log_time')->comment('记录日志每天唯一标识')->index()->default('');
            $table->timestamps();
        });
    }

    public function drop_member_credit_logs_table()
    {
        Schema::dropIfExists('member_credit_logs');
    }

    /**
     * 短信服务器表
     */
    public function create_member_sms_server_table()
    {
        Schema::create('member_sms_server', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('name')->comment('服务名称');
            $table->string('brief')->comment('服务描述')->default(1);
            $table->enum('status', [0, 1])->comment('状态，0关闭，1开启')->default(1);
            $table->integer('code_length')->comment('验证码长度');
            $table->string('code_content')->comment('验证码类型值');
            $table->string('admin_user')->comment('账号')->default('');
            $table->string('password')->comment('密码')->default('');
            $table->string('company_name')->comment('公司名')->default(1);
            $table->integer('admin_mobile')->comment('管理员手机号')->default(1);
            $table->integer('over')->comment('余额')->default(0);
            $table->integer('over_remind')->comment('余额提醒')->default(1);
            $table->string('send_url')->comment('发送信息接口')->default('');
            $table->integer('re_time')->comment('接收时间')->default(0);
            $table->string('content')->comment('发送的内容');
            $table->string('over_url')->comment('获取短信余额接口')->default('');
            $table->string('over_mobile')->comment('发送余额手机号')->default('');
            $table->string('over_content')->comment('发送余额内容')->default('');
            $table->integer('user_id')->comment('用户id');
            $table->string('user_name')->comment('创建用户名');
            $table->integer('update_user_id')->comment('更新用户id');
            $table->string('update_user_name')->comment('更新用户名');
            $table->string('ip')->comment('ip')->default('');
            $table->enum('charset', ['UTF-8', 'GBK'])->comment('内容编码')->default('UTF-8');
            $table->string('return_type')->comment('json')->default('json');
            $table->string('request_type')->comment('请求方法')->default('');
            $table->timestamps();
        });
    }

    public function drop_member_sms_server_table()
    {
        Schema::dropIfExists('member_sms_server');
    }

    /**
     * 存储验证码
     */
    public function create_member_sms_verify_table()
    {
        Schema::create('member_sms_verify', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('member_name')->comment('用户名');
            $table->string('verify_code')->comment('验证码');
            $table->timestamps();
        });
    }

    public function drop_member_sms_verify_table()
    {
        Schema::dropIfExists('member_sms_verify');
    }

    /**
     * 短信日志
     */
    public function create_member_sms_log_table()
    {
        Schema::create('member_sms_logs', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('member_name')->comment('用户名');
            $table->string('type')->comment('验证类型');
            $table->integer('count')->comment('发送次数');
            $table->string('log_time')->comment('记录日志每天唯一标识');
            $table->timestamps();
        });
    }

    public function drop_member_sms_log_table()
    {
        Schema::dropIfExists('member_sms_logs');
    }

    /**
     * 短信总数
     */
    public function create_member_sms_count_table()
    {
        Schema::create('member_sms_count', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('member_name')->comment('用户名');
            $table->integer('count')->comment('发送次数');
            $table->enum('status', [0, 1])->comment('手机号状态，0黑名单，1白名单')->default(1);
            $table->timestamps();
        });
    }

    public function drop_member_sms_count_table()
    {
        Schema::dropIfExists('member_sms_count');
    }

    /**
     * 会员相关设置
     */
    public function create_member_settings_table()
    {
        Schema::create('member_settings', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('group')->comment('分组名称')->index();
            $table->string('name')->comment('配置名称');
            $table->string('description')->comment('配置备注')->default('');
            $table->string('key')->comment('配置标识');
            $table->string('value')->comment('配置值')->default('');
//            $table->unique(['group', 'key']);
            $table->timestamps();
        });
    }

    public function drop_member_settings_table()
    {
        Schema::dropIfExists('member_settings');
    }

    private function create_member_sessions_table()
    {
        Schema::create('member_sessions', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->integer('member_id')->index();
            $table->string('token');
            $table->string('expire_time');
            $table->primary('token');
            $table->timestamps();
        });
    }

    private function drop_member_sessions_table()
    {
        Schema::dropIfExists('member_sessions');
    }

    private function create_member_platforms_table()
    {
        Schema::create('member_platforms', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->string('name')->comment('登录方式');
            $table->string('brief')->comment('简介')->default('');
            $table->string('sign')->index()->comment('sign');
            $table->enum('status', [0, 1])->index()->default(1)->comment('是否使用');
            $table->enum('display', [0, 1])->index()->default(1)->comment('是否展现');
            $table->enum('is_login', [0, 1])->index()->default(1)->comment('是否可以登录');
            $table->enum('is_register', [0, 1])->index()->default(1)->comment('是否可以注册');
            $table->string('account')->comment('授权账号')->default('');
            $table->string('api_key')->comment('授权apiKey')->default('');
            $table->string('secret_key')->comment('授权secretKey')->default('');
            $table->string('callback')->comment('回调地址')->default('');
            $table->string('creator')->comment('创建人')->default('');
            $table->string('creator_id')->comment('创建人id')->default(0);

            $table->timestamps();
        });
    }

    private function drop_member_platforms_table()
    {
        Schema::dropIfExists('member_platforms');
    }

}
