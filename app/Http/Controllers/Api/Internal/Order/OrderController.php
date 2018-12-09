<?php
/**
 * Created by PhpStorm.
 * User: lzhang
 * Date: 18-10-21
 * Time: 下午3:55
 * Email: lzhang@che300.com
 */

namespace App\Http\Controllers\Api\Internal\Order;


use App\Http\Controllers\BaseController;
use App\Models\Order\Orders;
use App\Models\Package\MemberPackage;
use App\Models\Package\Package;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function rechargeOrder(Request $request)
    {
        $validate = [
            'member_id' => 'required',
            'package_id' => 'required',
        ];

        $insert = collect($request->all())->only(array_keys($validate));
        $package_info = Package::find($insert['package_id']);
        if (!$package_info || !$insert['member_id']) {
            return $this->error([], '订单异常，请刷新后重试');
        }

        $save = [
            'member_id' => $insert['member_id'],
            'package_id' => $insert['package_id'],
            'counts' => $package_info['counts'],
            'cost_type' => 1,
            'type' => $package_info['business_type'],
            'cost_price' => $package_info['price']
        ];

        Orders::create($save);
        $memberPkg = MemberPackage::where('member_id', $insert['member_id'])->first();

        if (!$memberPkg) {
            $memberPkgIns = [
                'counts' => $package_info['counts'],
                'amount' => $package_info['price']
            ];

            MemberPackage::create($memberPkgIns);
        } else {
            $memberPkgIns = [
                'counts' => $memberPkg['counts'] + $package_info['counts'],
                'amount' => $memberPkg['amount'] + $package_info['price']
            ];
            MemberPackage::where('member_id', $insert['member_id'])->create($memberPkgIns);
        }

        return $this->success($memberPkgIns, '订单成功');
    }

    public function orderList(Request $request)
    {
        $page =  $request->get('page') ? : 1;
        $page_size = abs($request->get('page_size') ? : env('PAGE_SIZE'));
        $offset = abs($page - 1) * $page_size ;
        $order_list = Orders::where('is_deleted', 0)
            ->take(abs(intval($page_size)))
            ->skip($offset)
            ->with(['member', 'package'])
            ->get()
            ->toArray();

        $order_count = Orders::count();
        Orders::where('is_read', 0)->update('is_read', 1);
        $return = [
            'order_list' => $order_list,
            'operate_users_info' => [],
            'all_pages' => strval(ceil($order_count/$page_size)),
            'cur_page' =>$page
        ];

        return $this->success($return, '');
    }

    public function count()
    {
        $order_count = Orders::count();
        $return = [
            'count' => $order_count,
            'unread' => Orders::where("is_read", 0)->count()
        ];
        return $this->success($return, '');
    }

}