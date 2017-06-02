<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = ['id', 'name', 'prms', 'description', 'super_admin'];
    public function user(){
        $this->belongsToMany(User::class,'user_role','role_id','user_id');
    }
}
