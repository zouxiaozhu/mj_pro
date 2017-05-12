<?php
namespace App\Repository\MjInterface;

interface RoleInterface
{
    public function roleList($data);

    public function createRole($data);

    public function delRole($id);

    public function updateRole($data);
}