<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_Auth extends Model
{
    protected $table = 'role_auth';
    protected $fillable = ['id', 'role_id', 'auth_id'];
}
