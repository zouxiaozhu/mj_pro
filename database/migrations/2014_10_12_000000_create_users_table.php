<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('password');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('create_user_id')->nullable();
            $table->tinyInteger('locked')->default(0);
            $table->tinyInteger('reset_pwd')->default(0);
            $table->integer('avatar');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('access_id')->comment();
            $table->string('access_token')->comment();
            $table->integer('is_develop')->comment();
            $table->string('last_login_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
