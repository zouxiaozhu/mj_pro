<?php

namespace App\Models;

use App\Models\Backend\NavModel;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = ['id', 'name', 'prms', 'description', 'super_admin'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }

    public function scopeNav()
    {
        return $this->belongsToMany(NavModel::class, 'role_navs', 'role_id', 'nav_id');
    }

    public function scopePrms()
    {
        return $this->belongsToMany(Auth::class, 'role_auth', 'role_id', 'auth_id');
    }

    public function scopeIsRole($query, $role_id)
    {
//        if(is_string){
//            $role_ids  = explode(',',$role_id);
//            foreach($role_ids as $rid){
//
//            }
//        }
//        return $query->where('id',1);
    }

    public function scopeGetPrms($query, $role_ids = [],$field = '*')
    {
        return $query->join('role_auth', 'roles.id', '=', 'role_auth.role_id')
            ->join('auths', 'role_auth.auth_id', '=', 'auths.id')
            ->whereIn('roles.id', $role_ids)
            ->select($field);
    }

    public function scopeGetNavs($query, $role_ids = [], $field = '*')
    {
        return $query->join('role_navs as r_n', 'roles.id', '=', 'r_n.role_id')
            ->join('navs', 'r_n.nav_id', '=', 'navs.id')
            ->whereIn('roles.id', $role_ids)
            ->groupBy('navs.id')
            ->select(explode(',', $field));
    }
}
