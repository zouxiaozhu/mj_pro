<?php
namespace App\Http\Controllers\Api\Internal\Service;

use App\Http\Controllers\Controller;
class XunsearchController extends Controller
{
    public function __construct()
    {



    }

    public function splitWord()
    {
        $xs_path = realpath('/Users/jiuji/xunsearch/sdk/php/lib/XS.php');
        $ini_path = realpath('/Users/jiuji/xunsearch/sdk/php/app/demo.ini');
        if (!$ini_path) {
            return false;
        }
        require_once $xs_path;
        $xs = new \XS($ini_path);
        $xste = new \XSTokenizerScws();
        $search = $xste->getTokens('迅搜(xunsearch) - 开源免费中文全文搜索引擎|PHP全文检索|mysql...');
        $search = $xste->getTops('王成成 王城 张龙 展览共',1);
        var_dump($search);
    }


}