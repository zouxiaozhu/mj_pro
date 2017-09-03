<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreatePostTable extends Migration
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
        // 创建帖子限制表

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forums');
        Schema::drop('post');
        Schema::drop('comment');
        Schema::drop('notice');
        Schema::drop('post_limits');
        Schema::drop('post_option');
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
            $table->string('childs_id')->comment('所有的子版块')->default(0);
            $table->string('fathers_id')->comment('所有的Father版块')->default(0);
            $table->enum('is_last',[0,1])->comment('是否最后一级')->default(0);
            $table->string('title',30)->comment('名字');
            $table->integer('indexpic')->comment('图标');
            $table->string('brief')->nullable()->comment('简介');
            $table->string('ip')->nullable()->comment('IP信息');
            $table->string('create_user_id')->nullable()->comment('创建人用户ID');
            $table->enum('is_close',[0,1])->default(0)->comment('关闭板块');
            $table->enum('is_hot',[0,1])->default(0)->comment('热门板块');
            $table->enum('is_push',[0,1])->default(0)->comment('是否推送');
            $table->enum('status',[-1,0,1])->default(0)->comment('-1 拒绝通过 审核状态0-待审核 1-审核通过 ');
            $table->integer('post_num')->comment('帖子总数')->default(0);
            $table->timestamps();
        });
    }

    /**
     * 发帖
     */
    public function createPost()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->comment('站点id')->default(1);
            $table->integer('forum_id')->comment('板块');
            $table->integer('order_id')->comment('排序ID')->default(0);
            $table->integer('fathers_id')->comment('所有的Father版块')->default(0);
            $table->string('title',30)->comment('title');
            $table->string('brief')->nullable()->comment('简介');
            $table->text('content')->comment('内容');
            $table->enum('type',['vote','tuwen'])->comment('创建人');
            $table->string('address')->comment('发帖地址');
            $table->string('longitude')->comment('经度');
            $table->string('latitude')->comment('纬度');
            $table->string('ip')->nullable()->comment('IP信息');
            $table->enum('is_top',[0,1])->default(0)->comment('是否置顶');
            $table->enum('is_essence',[0,1])->default(0)->comment('是否精华');
            $table->enum('status',[0,1,2])->default(1)->comment('0 删除 1 默认 2恢复');
            $table->integer('comment_num')->comment('评论总数')->default(0);
            $table->integer('like_num')->comment('点赞数')->default(0);
            $table->integer('dislike_num')->comment('点踩数')->default(0);
            $table->integer('share_num')->comment('分享次数')->default(0);
            $table->timestamps();
        });
    }
    /**
     * 回复 或 评论
     * post_id post_fid=0 是恢复
     *
     */
    public function createComment()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id')->comment('评论回复id');
            $table->integer('site_id')->comment('站点id')->default(1);
            $table->integer('forum_id')->comment('板块id');
            $table->integer('post_id')->comment('帖子id');
            $table->integer('post_fid')->comment('主回复')->default(0);
            $table->string('reply_member_id')->comment('父级评论回复的会员名称')->nullable();
            $table->text('reply_member_name')->comment('回复内容');
            $table->integer('member_id')->comment('会员id')->default(0);
            $table->string('member_name')->comment('会员名称/游客名称');
            $table->string('member_avatar')->comment('会员头像');
            $table->integer('like_num')->comment('点赞数')->default(0);
            $table->integer('dislike_num')->comment('反对数')->default(0);
            $table->enum('status',[0,1,2])->comment('0被删除 1正常 2已恢复')->nullable();
            $table->timestamps();
        });
    }

    /**
     * 帖子的更新和通知
     */
    public function createNotice()
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->comment('站点id')->default(1);
            $table->enum('is_read',[0,1])->comment('已读 未读');
            $table->string('content')->commemt('提示内容');
            $table->integer('user_id')->comment('用户ID')->default(0);
            $table->enum('type',[''])->comment();
            $table->integer('fathers_id')->comment('所有的Father版块')->default(0);
            $table->enum('is_last',[0,1])->comment('是否最后一级')->default(0);
            $table->timestamps();
        });
    }

    /**
     * 帖子限制
     */
    public function createPostLimits()
    {
        Schema::create('post_limits', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id')->comment('自增id');
            $table->integer('site_id')->comment('站点id')->default(1);
            $table->integer('forum_id')->comment('板块id');
            $table->enum('type',['vote','tuwen'])->comment('');
            $table->integer('like_num')->comment('点赞数')->default(1);
            $table->integer('dislike_num')->comment('反对数')->default(1);
            $table->integer('min_vote')->comment('最小数')->default(1);
            $table->integer('max_vote')->comment('最大数')->default(1);
            $table->integer('create_limit_time')->comment('时间间隔')->default(0);
            $table->timestamps();
        });

    }

    /**
     * 点赞记录表
     */
    public function createPostOption()
    {
        Schema::create('post_option', function (Blueprint $table) {
            $table->engine = 'Myisam';
            $table->increments('id')->comment('自增id');
            $table->integer('site_id')->comment('站点id')->default(1);
            $table->integer('forum_id')->comment('板块id');
            $table->integer('post_id')->comment('帖子id');
            $table->integer('comment_id')->comment('评论id');
            $table->integer('member_name')->comment('点赞数')->default(1);
            $table->integer('member_id')->comment('反对数')->default(1);
            $table->integer('min_vote')->comment('最小数')->default(1);
            $table->integer('max_vote')->comment('最大数')->default(1);
            $table->timestamps();
        });
    }

}
