<?php
/**
 * Created by PhpStorm.
 * User: lzhang
 * Date: 18-8-5
 * Time: 下午1:46
 * Email: lzhang@che300.com
 */

namespace App\Http\Controllers\Api\Internal\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function addMember(Request $request)
    {
        $params = $request->all();
        $fill_able = ['member_name' => 'required|max:10|min:2', 'refer_user_id' => 'integer', 'tel' => 'required|size:11'];

        $message = ['member_name.required' => 'member_name can not empty', 'refer_user_id.integer' => 'refer_user_id can not illege', 'tel.required' => 'tel params error'];

        $validator = Validator::make( $params, $fill_able, $message );

        if ($validator->fails()) {
            return Response::error( [], $validator->errors()->first() );
        }
        $referee_user_id = $params['refer_user_id'];
        $member_id = $params['member_id'];
        $other = [
            'referee_id' => intval( $referee_user_id ),
            'password' => isset( $params['password'] ) AND $params['password'] ? Hash::make( $params['password'] ) : '',
            'operate_user_id' => auth()->user()->id
        ];

        $update = [
            'member_name' => trim( $params['member_name'] ),
            'enabled' => intval( $params['enabled'] ),
            'email' => trim( $params['email'] ),
            'tel' => intval( $params['tel'] ),
            'address' => strval($params['address'])
        ];

        $common_tel = Member::where( 'tel', strval( intval( $params['tel'] ) ) )
            ->where('enabled', 1)
            ->get()->toArray();

        $tels = array_column($common_tel, 'id');

        if (!$member_id) {
            $add = array_merge( $update, $other );

            if ($tels) {
                return Response::error( [], '手机号码重复' );
            }

            $r_add = Member::create( $add );
            if (!$r_add) {
                return Response::error( [], '新增会员失败' );
            }
            return Response::success( [], '新增会员成功' );
        }

        $up = Member::where('id', $member_id)->update($update);
        if (!$up) {
            return Response::error( [], '更新会员失败' );
        }
        return Response::success( [], '更新会员成功' );
    }

    public function delMember(Request $request)
    {
        $member_id = $request->get('member_id');

        if (!$member_id) {
            return Response::error([], '缺少会员信息');
        }

        $row = Member::where('id', intval($member_id))->update([
            'is_deleted' => 1
        ]);

        if ($row) {
            return Response::success([], '删除会员成功');
        }
        return Response::error([], '删除会员失败');

    }

    public function memberList(Request $request)
    {
        $return = [
            'member_list' => [],
            'operate_users_info' => [],
            'all_pages' => 1,
            'cur_page' => 1
        ];
        $page =  $request->get('page') ? : 1;
        $page_size = abs($request->get('page_size') ? : env('PAGE_SIZE'));
        $offset = abs($page - 1) * $page_size ;
        $member_list = Member::where('is_deleted', 0)
            ->take(abs(intval($page_size)))
            ->skip($offset)
            ->get()
            ->toArray();

        if (!$member_list) {
            return Response::success($return, '会员信息获取成功');
        }

        $member_counts = Member::where('is_deleted', 0)->count();

        $operate_users_info = User::whereIn('id', array_column($member_list, 'operate_user_id'))
            ->get()
            ->toArray();
        $operate_users_info = array_column($operate_users_info, null, 'id');

        $return = [
            'member_list' => $member_list,
            'operate_users_info' => $operate_users_info,
            'all_pages' => strval(ceil($member_counts/$page_size)),
            'cur_page' => $page
        ];

        return Response::success($return, '会员信息获取成功');
    }
    
}