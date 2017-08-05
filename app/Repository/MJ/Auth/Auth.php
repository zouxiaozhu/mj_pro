<?php
namespace App\Repository\MJ\Auth;

use App\Models\User;
use App\Repository\MjInterface\AuthInterface;
use Illuminate\Support\Facades\Auth as OAuth;


/**
 * Class Auth
 * @package App\Repository\MJ\Auth
 *
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
        //print_r(session()->all());
        //event(new Mail($user));
        return User::find(auth()->user()->id);
    }

    public function logout()
    {
        if(!auth()->user()->id){
            return response()->error('111','NO LOGIN');
        }
        $logout = OAuth::logout();
        return response()->success('111','LOGOUT ALREADY');
    }
}