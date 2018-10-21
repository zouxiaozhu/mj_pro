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
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function addOrder(Request $request, Orders $orders)
    {
        $validate = [
            'member_id' => 'required',
            'cost_type' => 'required',
            'business_type' => 'required',
            'package_id' => 'required',
        ];

//       switch ($request->get('cost_type')) {
//           case 1 :
//                break;
//           case 2 :
//                break;
//       }
        $insert = collect($request->all())->only(array_keys($validate));
        $ret = $orders->insert($insert);
    }
}