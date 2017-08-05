<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = ['id', 'name', 'prms', 'description', 'super_admin'];
    public function user(){
        return $this->belongsToMany(User::class,'user_role','role_id','user_id');
    }

    public function scopeIsRole($query,$role_id){
//        if(is_string){
//            $role_ids  = explode(',',$role_id);
//            foreach($role_ids as $rid){
//
//            }
//        }
//        return $query->where('id',1);
    }
}
