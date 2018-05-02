<?php

if(!function_exists('myerror')){
    function myerror($code,$message){
        return response()->error($code,$message);
    }
}
if(!function_exists('mysuccess')){
    function mysuccess($message){
        return response()->success($message);
    }
}