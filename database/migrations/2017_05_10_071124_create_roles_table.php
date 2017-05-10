<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles',function(Blueprint $table){
            $table->increments('id');
            $table->char('name',10)->unsigned();
            $table->varchar('prms')->unsigned();
            $table->tinyInteger('super_admin')->default(0);
            $table->varchar('description',100)->default('');
            $table->tinyInteger('expand')->nullable();
            $table->timestamp();


        });
        Schema::create('user_role',function (Blueprint $table){
            $table->integer('user_id')->index();
            $table->integer('role_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExist('roles');
        Schema::dropIfExist('user_role');

    }
}
