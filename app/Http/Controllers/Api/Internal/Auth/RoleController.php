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
    {
        return  get_loaded_extensions();
        return 111;
        $data = [
            'page_num' => $request->get('page_num') ? intval($request->get('page_num')) : 10,
            'page'     => $request->get('page_num') ? intval($request->get('page_num')) : 0
        ];
        return $this->role->roleList($data);
    }

    public function updateRole(){
       return $this->role->updateRole();
    }
}