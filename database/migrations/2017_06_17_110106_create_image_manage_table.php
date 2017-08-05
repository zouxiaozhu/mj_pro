<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageManageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createMediaMaterial();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function createMediaMaterial()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->enum('type',[1,2,3,4])->comment('图片 音频 视频 文件');
            $table->string('storage_path')->comment('存放位置');
            $table->timestamps();
        });
    }
}
