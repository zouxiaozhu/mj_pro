<?php

namespace App\Http\Controllers\Api\Member\Repositories;

use GuzzleHttp\Client;
use MXUAPI\Members\Models\MemberSMSLog;
use MXUAPI\Members\Models\MemberSMSVerify;
use MXUAPI\Members\Repositories\Interfaces\MemberSMSInterface;
use MXUAPI\Members\Models\MemberSMS as SMS;

class MemberSMS implements MemberSMSInterface
{
    public function getSMSServer($server_id = null)
    {
        if (!$server_id) {
            $server = SMS::inUse()->orderByOver()->first();
        } else {
            $server = SMS::inUse()->where('id', $server_id)->first();
        }

        return $server;
    }

    public function getSendCode($mobile, $server)
    {
        $mobile_verify = MemberSMSVerify::where('member_name', $mobile)->first();
        if ($mobile_verify) {
            $code = $mobile_verify->verify_code;
        } else {
            $code_length  = $server['code_length'] ?: 6;
            $code_content = $server['code_content'] ?: '0123456789';
            $code         = random_content($code_length, $code_content);
        }

        return $code;
    }

    public function sendCode($url, $mobile, $content)
    {
        $url    = strtr($url, ['{{MOBILE}}' => $mobile, '{{CONTENT}}' => $content]);
        $url    = $url . '&custom_appid=' . env('CLIENT_ID') . '&custom_appkey=' . env('CLIENT_SECRET');
        $client = new Client();
        $res    = $client->request('GET', $url, []);
        $res    = json_decode($res->getBody(), 1);
        if (!$res || !isset($res['send_status']) || isset($res['ErrorCode'])) {
            logger('[SendCode]: ' . isset($res['ErrorCode']) ? $res['ErrorText'] : '');
            return false;
        }

        return $res;
    }

    public function createVerifyCode($mobile, $code)
    {
        $verify_code = MemberSMSVerify::firstOrCreate(['member_name' => $mobile, 'verify_code' => $code]);

        return $verify_code;
    }

    public function createSendLog($mobile, $type)
    {
        $log   = MemberSMSLog::where('member_name', $mobile)->first();
        $today = date('Ymd', TIMENOW);

        if ($log && $log->log_time == $today) {
            $log->update(['log_time' => $today]);
            $log->increment('count');
        } else {
            MemberSMSLog::create(['member_name' => $mobile, 'type' => $type, 'count' => 1, 'log_time' => $today]);
        }
    }

    public function checkVerifyCode($member_name, $code)
    {
        $verify = MemberSMSVerify::where(['member_name' => $member_name, 'verify_code' => $code])->first();

        return $verify ? true : false;
    }

    public function deleteVerifyCode($member_name)
    {
        MemberSMSVerify::where('member_name', $member_name)->delete();
    }
}