<?php
namespace App\Http\Controllers\Api\External\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use Illuminate\Support\Facades\Auth as OAuth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Auth\Guard;
class MemberController extends Controller{

    public function __construct()
    {
        $this->checkLogin();
    }

    public function login()
    {
        $member_name =request('name','');
        $password = request('password');
        $user =  OAuth::guard('guards')->members([$member_name,$password]);
        return $user;
    }
    public function show()
    {
       $member = Member::get(['id','name','avatar','email'])->toArray();
       return Response::success($member);
    }

    public function updateAvatar()
    {
        $user_id = auth()->member()->id;
    }

    public function checkLogin()
    {
        if(!session()->get('access_token'));
    }



}