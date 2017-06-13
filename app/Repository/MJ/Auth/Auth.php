<?php
namespace App\Repository\MJ\Auth;


use App\Events\Mail;
use App\Repository\MjInterface\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth as OAuth;
use Illuminate\Support\Facades\Redis;

/**
 * Class Auth
 * @package App\Repository\MJ\Auth
 */
class Auth implements AuthInterface
{
    public function login($fill_able)
    {
        if (!isset($fill_able['remember'])) {
            $fill_able['remember'] = 0;
        }

        if (!User::where('name', $fill_able['name'])->where('locked', 1)->get()) {
            return 'Boom Error U Never Think';
        }
        // 登录用户
        $login = OAuth::attempt(['name' => $fill_able['name'], 'password' => $fill_able['password']], $fill_able['remember']);
        $user  = User::find(1);
        //event(new Mail($user));
        print_r(session()->all());
    }


    public function logout()
    {
        return $this->check('all');
        //$logout = OAuth::logout();
        if ($logout) {
            return 'success';
        } else {
            return '重试一次啊!my baby';
        }

    }

    public function check($prms)
    {
        $user_id = auth()->user()->id;
       // $role = User::find($user_id)->role()->select('prms')->get()->toArray();
        $ret = User::find($user_id)->hasRole('lVk7of8IiNnLAJUE');
        return ($ret);
    }
}