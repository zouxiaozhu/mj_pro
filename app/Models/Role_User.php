<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_User extends Model
{
    protected $table = 'user_role';
    protected $guarded = ['role_id','user_id'];

}
