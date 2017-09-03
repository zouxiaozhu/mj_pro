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
        if(!OAuth::check()){
            return false;
        }
        return true;
    }

    public function verifyPrms($prms = '')
    {
        $prms_info = session()->get('prms_info');
        $prms = explode('|',$prms);

        if(in_array('all',$prms_info)){
            return true;
        }

        $arr_prms = array_intersect($prms,$prms_info);
        if($arr_prms){
            return true;
        }
        return false;

//        if (User::find($user_id)->role->contains('prms', 'all')) {
//            return 'true';
//        };
//        $roles = User::find($user_id)->role->toArray();
//        $arr = [];
//        foreach ($roles as $role) {
//            $arr = array_merge(explode(',', $role['prms']), $arr);
//        }
//        $role_prms = array_unique($arr);
//        if (array_intersect($prms, $role_prms) != $prms) {
//            return 'false';
//        }
    }
}