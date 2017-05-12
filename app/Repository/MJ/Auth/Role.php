<?php
namespace App\Repository\MJ\Auth;

use App\Repository\MjInterface\RoleInterface;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements RoleInterface
{
    public function roleList($data)
    {
        $page     = $data['page'];
        $page_num = $data['page_num'];
        $offset   = ($page - 1) * $page_num;
        $role     = Role::skip($offset)->take($page_num)->get()->toArray();
        $count    = Role::count();
        return response()->success(['role' => $role, 'count' => $count]);
    }
}