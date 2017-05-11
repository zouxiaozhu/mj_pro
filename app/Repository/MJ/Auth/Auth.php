<?php
namespace App\Repository\MJ\Auth;

use App\Repository\MjInterface\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Aut
class Auth implements AuthInterface
{
    public function login($fill_able)
    {
        if (!User::where('name', $fill_able['name'])->where('locked', 1)->get()) {
            return 'Boom Error U Never Think';
        }

        $login = OAuth::attempt(['name' => $fill_able['name'], 'password' => $fill_able['password']], $fill_able['remember']);
        if($login){return 'login';}else{
            return 'fuse';
        }
    }
}