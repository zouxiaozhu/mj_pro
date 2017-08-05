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
        $this->createRole();
        $this->createAuth();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('user_role');

    }

    public function createRole()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->char('name', 10)->commemt('名字');
            $table->string('prms')->commemt('节点');
            $table->enum('super_admin', [0, 1])->default(0);
            $table->string('description', 100)->default('');
            $table->tinyInteger('expand')->nullable();
            $table->timestamps();


        });
        Schema::create('user_role', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role_id');
            $table->primary(['role_id', 'user_id']);
        });
    }

    public function createAuth()
    {
        Schema::create('auths', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->char('name', 10)->commemt('名字');
            $table->string('prms')->comment('');
        });
    }
}
