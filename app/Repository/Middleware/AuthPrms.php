<?php
namespace App\Repository\Middleware;

use App\Models\User;
use App\Repository\Middleware\MiddlewareInterface\AuthPrmsInterface;
use Illuminate\Support\Facades\Auth as OAuth;
define('SUPER_ADMIN', 1);
define('ADMIN', 2);

class AuthPrms implements AuthPrmsInterface
{
    public function __construct()
    {
        $prms=0;
        $prms = explode('|', $prms);
        $auth_id = auth()->user()->id;
        User::find($auth_id);

        if (!auth()->user()->id) {
            return 'false';
        }
    }

    public function check($prms = '')
    {
        if(!OAuth::check()){
            return 'false';
        }
        $user_id = auth()->user()->id;
        if ($user_id == SUPER_ADMIN || $user_id == ADMIN) {
            return 'true';
        }
        if (User::find($user_id)->role->contains('prms', 'all')) {
            return 'true';
        };
        $roles = User::find($user_id)->role->toArray();
        $arr = [];
        foreach ($roles as $role) {
            $arr = array_merge(explode(',', $role['prms']), $arr);
        }
        $role_prms = array_unique($arr);
        if (array_intersect($prms, $role_prms) != $prms) {
            return 'false';
        }
        return 'true';
    }
}