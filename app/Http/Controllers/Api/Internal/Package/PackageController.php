<?php
/**
 * Created by PhpStorm.
 * User: lzhang
 * Date: 18-9-24
 * Time: 上午11:24
 * Email: lzhang@che300.com
 */

namespace App\Http\Controllers\Api\Internal\Package;


use App\Http\Controllers\BaseController;
use App\Models\Package\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class PackageController extends BaseController
{
    protected $map_msg = [
        1 => '美甲次数',
        2 => '美甲折扣',
        3 => '纹眉次数',
        4 => '纹眉折扣',
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function businessType()
    {
        $msgs = $this->map_msg;
        $business_type = [];
        foreach ($msgs as $key => $msg) {
            $business_type[] = [
                'business_type' => $key,
                'msg' => $msg,
                'packages' => Package::where('enabled', 1)->where('business_type', $key)
                    ->get()->toArray()
            ];
        }



        return $this->success(collect($business_type)->keyBy('business_type')->toArray(), "");
    }

    public function addPackage()
    {

        $business_type = intval($this->request->get('business_type', 0));
        if (! in_array($business_type, [1, 2, 3, 4])) {
            return  Response::error([], '套餐类型不合法');
        }
        $origin_price = $this->request->get('origin_price', 0);
        if (! $origin_price or $origin_price < 0 or !is_numeric($origin_price)) {
            return  Response::error([], '套餐价格不合法');
        }

        $insert = [
            'origin_price' => $origin_price,
            'business_type' => $business_type,
            'enabled' => 1,
            'name' => $this->request->input('name')
        ];

        if (in_array($business_type, [2, 4])) {
            // discount
            $discount = $this->request->get('discount', 0 );
            if (! $discount or !is_numeric($discount) or $discount > 100 or $discount <= 0) {
                return  Response::error([], '折扣不合法');
            }

            $insert['discount'] = $discount;
            $insert['price'] = $origin_price * $discount;

        } else {
            // counts
            $counts = $this->request->get('counts', 0 );
            if (! $counts or !is_numeric($counts) or $counts < 1 ) {
                return  Response::error([], '次数不合法');
            }

            $insert['counts'] = $counts;
            $insert['price'] = ceil($origin_price / $counts);
        }
        $id = $this->request->get('id');
        if ($id) {
            $package = Package::where('id', intval($id))->update($insert);
        } else {
            $package = Package::create($insert);
        }

        if (! $package) {
            return $this->error([], ($id ? '更新' : '添加' ) . '失败');
        }

        return $this->success($package, ($id ? '更新' : '添加' ) . '成功');
    }

    public function packageList(Request $request)
    {
        $package_list = Package::where('enabled', 1)
            ->get()
            ->toArray();
        return $this->success(array_values($package_list), '');
    }
    public function package(Request $request)
    {
        $return = [
            'package_list' => [],
            'operate_users_info' => [],
            'all_pages' => 1,
            'cur_page' => 1
        ];
        $page =  $request->get('page') ? : 1;
        $page_size = abs($request->get('page_size') ? : env('PAGE_SIZE'));
        $offset = abs($page - 1) * $page_size ;
        $package_list = Package::where('enabled', 1)
            ->take(abs(intval($page_size)))
            ->skip($offset)
            ->get()
            ->toArray();

        if (!$package_list) {
            return Response::success($return, '会员信息获取成功');
        }

        $package_counts = Package::where('enabled', 1)->count();

        $return = [
            'package_list' => [],
            'operate_users_info' => [],
            'all_pages' => strval(ceil($package_counts/$page_size)),
            'cur_page' => $page
        ];

        $package_list = $this->mapPackageList($package_list);
        $return['package_list'] = $package_list;
        return response()->success($return, '会员信息获取成功');
    }
    
    public function mapPackageList($lists = [])
    {
        if (! $lists) {
            return [];
        }
        $map_msg = $this->map_msg;
        foreach ($lists as &$list) {
            $list['business_content'] = isset($map_msg[$list['business_type']]) ?
                $map_msg[$list['business_type']] : '';
        }

        return $lists;
    }

    public function show($id)
    {
        $package = Package::find(intval($id));
        $package = $package->toArray();
        return Response::success($package, '会员套餐获取成功');
    }

    public function delPackage()
    {
        $id = $this->request->get('id', 0);
        if (!$id) {
            return Response::error([], '删除套餐失败');
        }

        $rows = Package::where('enabled', 1)->where('id', $id)->update([
            'enabled' => 0
        ]);

        if (! $rows) {
            return Response::error([], '删除套餐失败');
        }

        return Response::success($rows, '删除套餐成功');
    }
}