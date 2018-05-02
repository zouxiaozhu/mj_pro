<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createWaterSetting();

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

    protected function createWaterSetting()
    {
        Schema::create('water_setting', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->char('name', 10)->commemt('名字');
            $table->float('width')->comment('宽度');
            $table->float('height')->comment('高度');
            $table->float('bottom_top')->comment('右下角距离顶端的位置');
            $table->float('bottom_left')->comment('右下角距离left的位置');
            $table->string('user_module')->comment('采用的模块');
            $table->integer('is_use')->comment();
            $table->string('water_path')->comment('water位置');
            $table->integer('opacity')->comment('透明度');
            $table->timestamps();
        });
    }
}
