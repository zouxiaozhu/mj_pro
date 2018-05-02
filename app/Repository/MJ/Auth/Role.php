<?php
namespace App\Repository\MJ\Auth;

use App\Repository\MjInterface\RoleInterface;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements RoleInterface
{
    /**
     *  获取用户角色列表信息
     *
     * @param $data
     * @return mixed
     */
    public function roleList($data)
    {
        $page = $data['page'];
        $page_num = $data['page_num'];
        $offset = ($page - 1) * $page_num;
        $role = Role::skip($offset)->take($page_num)->get()->toArray();
        $count = Role::count();
        return response()->success(['role' => $role, 'count' => $count]);
    }

    public function updateRole($data)
    {
        // TODO: Implement updateRole() method.
    }

    public function delRole($id)
    {
        // TODO: Implement delRole() method.
    }

    public function createRole($data)
    {
        // TODO: Implement createRole() method.
    }


}