<?php
namespace App\Repository\Middleware;

use App\Models\User;
use App\Repository\Middleware\MiddlewareInterface\AuthPrmsInterface;

class AuthPrms implements AuthPrmsInterface
{

    public function check($prms)
    {
        $prms = explode('|', $prms);
        $auth_id = auth()->user()->id;
        User::find($auth_id)

    }


}