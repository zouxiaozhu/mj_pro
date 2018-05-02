<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //  $this->createMemberGroup();
        $this->createMemberInfo();
//        $this->createMemeberRecord();
//        $this->createMemberCredit();
//        $this->createMemberRules();
//        $this->createMemberCash();
        $this->createDeveloper();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('members');
        Schema::drop('developer');
    }

    private function createMemberGroup()
    {

    }

    private function createMemberInfo()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->nullable();
            $table->string('password');
            $table->string('email')->nullable();
            $table->integer('phone')->unique()->nullable();
            $table->enum('locked',[0,1])->default(0);
            $table->integer('access_id')->comment()->nullable();
            $table->string('access_token')->comment()->nullable();
            $table->enum('is_develop',[0,1])->comment();
            $table->string('last_login_time')->default(time())->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    private function createDeveloper(){
        Schema::create('developers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('access_id');
            $table->string('access_key');
            $table->timestamps();
        });
    }
}
