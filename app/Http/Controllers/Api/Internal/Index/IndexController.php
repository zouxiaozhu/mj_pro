<?php
namespace App\Http\Controllers\Api\Internal\Index;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use App\Repository\MJ\Auth\Role;

class IndexController extends Controller
{
    public function userInfo()
    {
        $user_id = auth()->user()->id;

        $user_role = User::find(2)->role;

        print_r(session()->all());
    }


}
