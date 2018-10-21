<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

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
    }

    private function createUser()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('password');
            $table->string('email')->default('');
            $table->string('phone' ,20)->unique()->default('');
            $table->integer('create_user_id')->default(0);
            $table->enum('enabled', [0,1])->default(0);
            $table->string('last_login_time')->default(time())->nullable();
            $table->string('avatar');
            $table->rememberToken();
            $table->timestamps();
        });
    }

}
