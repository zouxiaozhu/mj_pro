<?php
namespace App\Http\Controllers\Api\Member\Repositories\Interfaces;
interface MemberInterface
{
    public function checkBind($member_name, $type);

    public function getMemberByMobile($mobile);

    public function getBindInfoById($member_id);

    public function getBindInfoByPlatform($platform_id);

    public function checkMemberName($member_name);

    public function createMember($data);

    public function createBind($data);

    public function getMemberInfoById($member_id);

    public function createMemberInfo($data);

    public function addTrace($data);

    public function getMemberById($member_id);

    public function getMember($where);

    public function setToken($member_id, $expire = 3600);

    public function getToken($member_id);

    public function updateMember($member_id, $data);

    public function updateMemberInfo($member_id, $data);

    public function updateMemberBind($member_id, $data);

    public function getMemberPlatforms();
}