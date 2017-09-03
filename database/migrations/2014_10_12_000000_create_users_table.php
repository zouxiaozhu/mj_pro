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
        $this->createUser();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('developer');
    }

    private function createUser()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->nullable();
            $table->string('password');
            $table->string('email')->nullable();
            $table->integer('phone')->unique()->nullable();
            $table->integer('create_user_id')->nullable();
            $table->enum('locked',[0,1])->default(0);
            $table->tinyInteger('reset_pwd')->default(0);
            $table->integer('access_id')->comment();
            $table->string('access_token')->comment();
            $table->enum('is_develop',[0,1])->comment();
            $table->string('last_login_time')->default(time())->nullable();
            $table->string('avatar');
            $table->rememberToken();
            $table->timestamps();
        });
    }

}
