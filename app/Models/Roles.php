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

    public function scopePrms()
    {
        return $this->belongsToMany(Auth::class,'role_auth','role_id','auth_id');
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

    public function scopeGetPrms($query,$role_ids)
    {
        return $query->leftJoin('role_auth', 'roles.id','=','role_auth.role_id')->whereIn('roles.id',$role_ids)
->leftJoin('auths','role_auth.auth_id','=','auths.id')->select('auths.name','auths.prm');
    }
}
