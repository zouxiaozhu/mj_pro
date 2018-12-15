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
use App\Models\Member\Member;
use App\Models\Order\Orders;
use App\Models\Package\MemberPackage;
use App\Models\Package\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {

            $save = [
                'member_id' => $insert['member_id'],
                'package_id' => $insert['package_id'],
                'counts' => $package_info['counts'],
                'cost_type' => 1,
                'type' => $package_info['business_type'],
                'cost_price' => $package_info['price'],
                'comment' => $request->input('comment')
            ];

            Orders::create($save);
            $memberPkg = MemberPackage::where('member_id', $insert['member_id'])
                ->where('package_id', $insert['package_id'])->first();

            if (!$memberPkg) {
                $memberPkgIns = [
                    'counts' => $package_info['counts'],
                    'amount' => $package_info['price'],
                    'member_id' => $insert['member_id'],
                    'package_id' => $insert['package_id'],
                    'car_no' => $insert['member_id'] . '-' . $insert['package_id'] . md5($insert['member_id'] . '-' . $insert['package_id'])
                ];
                MemberPackage::create($memberPkgIns);
            } else {
                $memberPkgIns = [
                    'counts' => $memberPkg['counts'] + $package_info['counts'],
                    'amount' => $memberPkg['amount'] + $package_info['price'],
                    'member_id' => $insert['member_id'],
                    'package_id' => $insert['package_id'],
                ];
                MemberPackage::where('member_id', $insert['member_id'])->update($memberPkgIns);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error([], '订单失败');
        }
        return $this->success($memberPkgIns, '订单成功');
    }

    public function orderList(Request $request)
    {
        $page = $request->get('page') ?: 1;
        $page_size = abs($request->get('page_size') ?: env('PAGE_SIZE'));
        $offset = abs($page - 1) * $page_size;

        $order_list = Orders::where('is_deleted', 0)
            ->take(abs(intval($page_size)))
            ->skip($offset)
            ->with(['member', 'package']);

        if ($request->get('type')) {
            $order_list = $order_list->where('cost_type', $request->get('type'));
        }

        if ($request->get('tel')) {
            $member = Member::where('tel', (int)$request->get('tel'))->first();
            $order_list = $order_list->where('member_id', $member ? $member->id : 0);
        }

        if ($request->get('member_name')) {
            $member_ids = Member::where('member_name','like',  '%'.$request->get('member_name').'%')->get()->pluck('id')->toArray();
            $order_list = $order_list->whereIn('member_id', $member_ids);
        }

        $order_list = $order_list->orderBy('id', 'desc')->get()
            ->toArray();

        $order_count = Orders::count();
        Orders::where('is_read', 0)->update(['is_read' => 1]);
        $return = [
            'order_list' => $order_list,
            'operate_users_info' => [],
            'all_pages' => strval(ceil($order_count / $page_size)),
            'cur_page' => $page
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

    public function consume(Request $request)
    {
        $validate = [
            'member_id' => 'required',
            'card_no' => 'required',
        ];
        $card_no = $request->input('card_no');
        $insert = collect($request->all())->only(array_keys($validate));
        $memberPkg = MemberPackage::where('card_no', $card_no)->where('counts', ">", 0)->first();

        if (!$memberPkg || !$insert['member_id'] || !$card_no) {
            return $this->error([], '订单异常，请刷新后重试');
        }

        $count = $request->input('count', 1);
        $update = [
            'counts' => $memberPkg['counts'] - $count
        ];
        DB::beginTransaction();
        try {

            MemberPackage::where('card_no', $card_no)->update($update);
            $package = Package::find($memberPkg['package_id']);
            $save = [
                'member_id' => $insert['member_id'],
                'package_id' => $memberPkg['package_id'],
                'counts' => $count,
                'cost_type' => 2,
                'type' => $package['business_type'],
                'cost_price' => $package['price'],
                'comment' => $request->input('comment', '')
            ];

            Orders::create($save);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error([], '消费失败');
        }
        return $this->success([], '消费成功');
    }

}