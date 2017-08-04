<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建板块
        $this->createForums();
        // 创建帖子
        $this->createPost();
        // 评论或者回复
        $this->createComment();
        // 创建站内信
        $this->createNotice();
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
     * 创建板块列表
     * @param string $connection
     */
    public function createForums()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fid')->comment('上级板块')->default(0);
            $table->integer('order_id')->comment('排序ID')->default(0);
            $table->integer('childs_id')->comment('所有的子版块')->default(0);
            $table->integer('fathers_id')->comment('所有的Father版块')->default(0);
            $table->enum('is_last',[0,1])->comment('是否最后一级')->default(0);
            $table->string('title',30)->comment('名字');
            $table->integer('indexpic')->comment('图标');
            $table->string('brief')->nullable()->comment('简介');
            $table->string('create_user')->comment('板块或分类创建人');
            $table->string('ip')->nullable()->comment('IP信息');
            $table->string('create_user_id')->nullable()->comment('创建人用户ID');
            $table->enum('close',[0,1])->default(0)->comment('关闭板块');
            $table->enum('is_hot',[0,1])->default(0)->comment('热门板块');
            $table->enum('is_push',[0,1])->default(0)->comment('是否推送');
            $table->enum('status',[-1,0,1])->default(0)->comment('-1 拒绝通过 审核状态0-待审核 1-审核通过 ');
            $table->timestamps();
        });
    }

    /**
     * 发帖
     */
    public function createPost()
    {
        
    }

    /**
     * 回复 或 评论
     */
    public function createComment()
    {
        
    }

    /**
     * 帖子的更新和通知
     */
    public function createNotice()
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('is_read',[0,1])->comment('已读 未读');
            $table->string('content')->commemt('提示内容');
            $table->integer('user_id')->comment('用户ID')->default(0);
            $table->enum('type',[''])->comment();
            $table->integer('fathers_id')->comment('所有的Father版块')->default(0);
            $table->enum('is_last',[0,1])->comment('是否最后一级')->default(0);
            $table->timestamps();
        });
    }
}
