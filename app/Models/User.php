<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, EntrustUserTrait {
        Authorizable::can as may;
        EntrustUserTrait::can insteadof Authorizable;
    }
    protected $table = 'users';
    protected $fillable = [
        'name', 'password', 'create_user_id'
    ];

    public function role()
    {
        return $this->belongsToMany('App\Models\Roles', 'user_role', 'user_id', 'role_id');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->contains('prms',$role);
        }

        return $role->intersect($this->role)->count();
    }

    public function scopeIsAdmin(){
        return $user_id =auth()->user()->id ==1 ? 1 : 0 ;
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setGetLastLoginAttribute($value)
    {

    }

    public static function getname()
    {

    }


}
