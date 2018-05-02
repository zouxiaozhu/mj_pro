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
        $this->createRoleAuth();
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
        Schema::dropIfExists('role_auth');
        Schema::dropIfExists('role_navs');
        Schema::dropIfExists('navs');
    }

    public function createRole()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->char('name', 10)->commemt('名字')->default('');
            $table->enum('super_admin', [0, 1])->default(0);
            $table->string('description', 100)->default('');
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->default(0);
            $table->integer('role_id')->default(0);
            $table->timestamps();
        });
    }

    public function createAuth()
    {
        Schema::create('auths', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->char('name', 10)->commemt('名字')->default('');
            $table->string('controller')->comment('')->default('');
            $table->string('action')->comment('')->default('');
            $table->timestamps();
        });
    }

    public function createRoleAuth()
    {
        Schema::create('role_auth', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('role_id')->commemt('名字')->default('');
            $table->string('auth_id')->comment('auth_id')->default(0);
            $table->timestamps();
        });
    }


    public function createNav()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('name')->commemt('名字')->default('');
            $table->string('key')->comment('')->default('');
            $table->string('depth')->comment('')->default(0);
            $table->string('nav_fid')->comment('')->default(0);
            $table->timestamps();
        });
    }

    public function createNavRole(){
        Schema::create('role_navs', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
                $table->integer('role_id')->commemt('名字')->default(0);
            $table->string('nav_fid')->comment('')->default(0);
            $table->timestamps();
        });
    }
}
