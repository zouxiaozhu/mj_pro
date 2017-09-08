<?php

namespace App\Http\Controllers\Api\Member\Repositories;

use MXUAPI\Members\Models\MemberBind;
use MXUAPI\Members\Models\MemberInfo;
use MXUAPI\Members\Models\MemberPlatform;
use MXUAPI\Members\Models\MemberSession;
use MXUAPI\Members\Models\MemberSetting;
use MXUAPI\Members\Models\MemberTrace;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberInterface;
use App\Http\Controllers\Api\Member\Models\Member as MemberModel;

class Member implements MemberInterface
{
    public function getMemberById($member_id)
    {
        $member = MemberModel::find($member_id);

        return $member;
    }

    public function getMemberByMobile($mobile)
    {
        $member = MemberModel::where('mobile', $mobile)->first();

        return $member;
    }

    public function getBindInfoById($member_id)
    {
        $binds = MemberBind::where('member_id', $member_id)->get();

        return $binds;
    }

    public function getBindInfoByPlatform($platform_id)
    {
        $binds = MemberBind::where('platform_id', $platform_id)->first();

        return $binds;
    }

    public function checkBind($member_name, $type)
    {
        $bind_info = MemberBind::where(['platform_id' => $member_name, 'type' => $type])->first();

        return $bind_info ? true : false;
    }

    public function checkMemberName($member_name)
    {
        $res = MemberModel::where('member_name', $member_name)->first();

        return $res ? true : false;
    }

    public function createMember($data)
    {
        $member = MemberModel::create($data);
        return $member;
    }

    public function createBind($data)
    {
        $bind = MemberBind::create($data);

        return $bind;
    }

    public function getMemberInfoById($member_id)
    {
        $member_info = MemberInfo::where('member_id', $member_id)->first();

        return $member_info;
    }

    public function createMemberInfo($data)
    {
        $member_info = MemberInfo::create($data);

        return $member_info;
    }

    public function addTrace($data)
    {
        $trace = MemberTrace::create($data);

        return $trace;
    }

    public function getMember($where)
    {
        $member = MemberModel::where($where)->first();

        return $member;
    }

    public function setToken($member_id, $expire = 3600)
    {
        if (!$session = MemberSession::where('member_id', $member_id)->first()) {
            // 不存在创建
            $token   = md5($member_id . time());
            $expire  = TIMENOW + $expire;
            $session = MemberSession::create(['member_id' => $member_id, 'token' => $token, 'expire_time' => $expire]);
        } else {
            // 存在更新时间
            $token  = md5($member_id . time());
            $expire = TIMENOW + $expire;
            $session->update(['token' => $token, 'expire_time' => $expire]);
        }

        return $token;
    }

    public function getToken($member_id)
    {
        $session = MemberSession::where('member_id', $member_id)->first();

        return $session ? $session->token : false;
    }

    public function updateMember($member_id, $data)
    {
        $update = MemberModel::where('id', $member_id)->update($data);

        return $update ? true : false;
    }

    public function updateMemberInfo($member_id, $data)
    {
        $update = MemberInfo::where('member_id', $member_id)->update($data);

        return $update ? true : false;
    }

    public function updateMemberBind($member_id, $data)
    {
        $update = MemberBind::where('member_id', $member_id)->update($data);

        return $update ? true : false;
    }

    public function getMemberPlatforms()
    {
        $platforms = MemberPlatform::inUse()->display()->select(['name', 'brief', 'sign', 'display', 'is_login', 'is_register'])->get();

        return $platforms;
    }
}