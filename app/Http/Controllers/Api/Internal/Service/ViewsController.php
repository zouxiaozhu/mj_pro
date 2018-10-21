<?php
/**
 * Created by PhpStorm.
 * User: lzhang
 * Date: 18-8-4
 * Time: 下午1:54
 * Email: lzhang@che300.com
 */

namespace App\Http\Controllers\Api\Internal\Service;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;

class ViewsController  extends Controller
{
    public function getLogin()
    {
        return view('admin/index/login');
    }

    public function getHome()
    {
        return view('admin/index/home');
    }

    public function addMember()
    {
        $member_id = request('member_id');
        $member_id && $member_info = Member::find($member_id)->toArray();
        return view('admin/member/add', [
            'member_id' => $member_id,
            'member_info' => $member_id ? $member_info : []
        ]);
    }

    public function memberList() {
        return view('admin/member/list');
    }

    public function getOrder()
    {
        return view('admin/order/add');
    }

    public function packageList()
    {
        return view('admin/package/list');
    }

    public function package($id = 0)
    {
        return view('admin/package/add', [
            'id' => intval($id)
        ]);
    }
}