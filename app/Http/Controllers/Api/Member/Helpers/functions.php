<?php
if (!function_exists('random_content')) {
    function random_content($length = 6, $content = '0123456789')
    {
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $content[mt_rand(0, strlen($content) - 1)];
        }
        
        return $str;
    }
}

if (!function_exists('verify_mobile')) {
    function verify_mobile($mobile)
    {
        $preg = '/^(?:13|14|15|17|18)[0-9]{9}$/';
        $res  = preg_match($preg, $mobile) ? true : false;
        
        return $res;
    }
}

if (!function_exists('verify_email')) {
    function verify_email($email)
    {
        $preg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/';
        $res  = preg_match($preg, $email) ? true : false;
        
        return $res;
    }
}