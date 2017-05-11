<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'Users';
    protected $fillable = [
        'name','password', 'create_user_id'
    ];

}
