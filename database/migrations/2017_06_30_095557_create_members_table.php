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
        $this->create_cost_log();
        $this->create_member_card();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


    }

    /**
     * 会员主表
     */
    public function create_member_members_table()
    {
        Schema::create('member_members', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id');
            $table->string('member_name')->comment('会员名')->dafault('');
            $table->string('nick_name')->comment('昵称')->default('');
            $table->string('tel', 20)->comment('手机')->unique();
            $table->string('address', 200)->comment('地址');
            $table->string('password')->default('');
            $table->string('avatar')->comment('头像')->default('');
            $table->string('email')->comment('邮箱');
            $table->string('company')->comment('公司');
            $table->tinyInteger('enabled')->comment('状态，0禁用，1活跃')->default(1);
            $table->timestamp('last_cost_time')->comment('最后消费时间');
            $table->integer('referee_id')->comment('推荐人ID')->default(0);
            $table->integer('operate_user_id')->comment('管理员')->default(0);
            $table->tinyInteger('is_deleted')->comment('是否被删除')->default(0);
            $table->timestamps();
        });
    }

    public function create_member_card()
    {
        Schema::create('member_packages', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id');
            $table->decimal('origin_price', 6, 2)->comment('')->default(0);
            $table->integer('discount')->comment('')->default(0);
            $table->decimal('price', 6, 2)->comment('')->default(0);
            $table->tinyInteger('type')->comment('状态，1 美甲 2 纹眉')->default(0);
            $table->tinyInteger('business_type')->comment('业务类型 1次数  2折扣');
            $table->tinyInteger('counts')->comment('次数')->default(1);
            $table->tinyInteger('enabled')->comment('状态，0禁用，1活跃')->default(1);
            $table->timestamps();
        });

        Schema::create('member_package_cards', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->string('card_no')->index();
            $table->tinyInteger('card_type')->comment('1 美甲，2 纹眉')->default(0);
            $table->integer('member_id')->comment('')->default(0);
            $table->integer('package_id')->comment('')->default(0);
            $table->tinyInteger('counts')->comment('次数')->default(0);
            $table->decimal('amount',6, 2)->comment('账户金额')->default(0);
            $table->tinyInteger('enabled')->comment('状态，0禁用，1活跃')->default(1);
            $table->timestamps();
        });
    }

    public function create_cost_log()
    {
        Schema::create('member_order', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->uuid('id');
            $table->decimal('cost_price', 6, 2)->comment('手机')->default(0);
            $table->integer('counts')->comment('次数')->default(0);
            $table->integer('member_id')->comment('用户')->default(0)->index();
            $table->integer('package_id')->comment('')->default(0);
            $table->tinyInteger('is_deleted')->comment('状态，0禁用，1活跃')->default(0);
            $table->tinyInteger('type')->comment('状态，1 美甲，2 纹眉')->default(0);
            $table->tinyInteger('cost_type')->comment('状态，1 充值，2 消费')->default(1);
            $table->string('comment')->comment('消费备注')->default('');
            $table->integer('operate_user_id')->comment('管理员')->default(0);
            $table->timestamps();
        });
    }
}
