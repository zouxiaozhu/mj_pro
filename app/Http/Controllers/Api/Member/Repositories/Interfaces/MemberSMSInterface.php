<?php
namespace App\Http\Controllers\Api\Member\Repositories\Interfaces;
interface MemberSMSInterface
{
    public function getSMSServer($server_id = null);

    public function getSendCode($mobile, $server);

    public function sendCode($url, $mobile, $content);

    public function createVerifyCode($mobile, $code);

    public function createSendLog($mobile, $type);

    public function checkVerifyCode($member_name, $code);

    public function deleteVerifyCode($member_name);
}