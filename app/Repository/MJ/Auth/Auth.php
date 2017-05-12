<?php
namespace App\Repository\MJ\Auth;

use App\Repository\MjInterface\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth as OAuth;

class Auth implements AuthInterface
{
    public function login($fill_able)
    {
        if (!User::where('name', $fill_able['name'])->where('locked', 1)->get()) {
            return 'Boom Error U Never Think';
        }
        // 登录用户
        $login = OAuth::attempt(['name' => $fill_able['name'], 'password' => $fill_able['password']], $fill_able['remember']);

//        if ($login) {
//            $fill_able['_token'] = session('_token');
//            return json_encode($fill_able);
//        } else {
//
//            return 'fuse';
//        }

    }


    public function logout()
    {
        $logout = OAuth::logout();
        if ($logout) {
            return 'success';
        } else {
            return '重试一次啊!my baby';
        }

    }
}