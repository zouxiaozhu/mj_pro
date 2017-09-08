<?php
namespace App\Http\Controllers\Api\Member\Repositories;

use App\Http\Controllers\Api\Member\Models\MemberPlatform;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberSettingInterface;

class MemberSetting implements MemberSettingInterface
{
    public function getSetting($sign)
    {
        $set = MemberPlatform::where('sign', $sign)->first();
       
        if (!$set) {
            return false;
        }

        return $set;
    }
}