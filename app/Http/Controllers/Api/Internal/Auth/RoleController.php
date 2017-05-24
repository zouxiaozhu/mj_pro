<?php
namespace App\Http\Controllers\Api\Internal\Auth;

use App\Http\Controllers\Controller;
use App\Repository\MjInterface\RoleInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
    }

    public function roleList(Request $request)
    {return 1111;
       //php:Image::make(base_path('public/foo.png'))->resize(50,50)->save('new_foo.png');

        // return 1111;

//        $data = [
//            'page_num' => $request->get('page_num') ? intval($request->get('page_num')) : 10,
//            'page'     => $request->get('page_num') ? intval($request->get('page_num')) : 0
//        ];
//        return $this->role->roleList($data);
    }


    public function updateRole(){
       return $this->role->updateRole();
    }
}