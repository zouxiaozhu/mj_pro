<?php
namespace App\Http\Controllers\Api\Member\Repositories\Interfaces;
interface MemberSettingInterface
{
    public function getSetting($sign);
}