<?php
/**
 * Created by PhpStorm.
 * User: lzhang
 * Date: 18-9-24
 * Time: 上午11:22
 * Email: lzhang@che300.com
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function success($data = [], $msg = '操作成功')
    {
        return Response::success($data, $msg);
    }

    protected function error($data = [], $msg = '操作成功')
    {
        return Response::error($data, $msg);
    }
}