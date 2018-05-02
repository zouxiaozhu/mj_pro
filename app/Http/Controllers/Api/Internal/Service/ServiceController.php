<?php
namespace App\Http\Controllers\Api\Internal\Service;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    public function createExcel()
    {
//        Excel::create('Laravel Excel', function($excel) {
//
//            $excel->sheet('Excel sheet', function($sheet) {
//
//                $sheet->setOrientation('landscape');
//
//            });
//
//        })->export('xls');

   return $this->Importexcel();

    }

    /*
     * Excel::create('学生成绩',function($excel) use ($cellData){
			$excel->sheet('score', function($sheet) use ($cellData){
				$sheet->rows($cellData);
			});
		})->export('xls');
     * */

    public function Importexcel(){
        $cellData = $this->excel;
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->store('xls')->export('xls')->iconv('UTF-8', 'GBK', '学生成绩');

//        $res = [];
//        Excel::load( public_path('ser.xls'), function($reader) use( &$res ) {
//            $reader = $reader->getSheet(0);
//            $res = $reader->toArray();
//        });
//        return $res;
    }

//    public function excelExport(){
////这里需要使用use来传递变量给内部闭包,这里假设$result2是一个要转换成excel的数组数据
//        Excel::create('testexcel', function ($excel) use ($result2, $apiHost) {
//            $excel->sheet('Sheetname', function ($sheet) use ($result2, $apiHost){
//
//                // Sheet manipulation
//                //需要注意的地方1  数组to sheet null  A1从row 开始
//                $sheet->fromArray($result2, null, 'A1', false, false);
//                //需要注意的地方2
//                foreach ($result2 as $index=>$item) {
//                    if($index == 0 ){ //排除标题row
//                        continue;
//                    }
//                    //J2:J代表excel的读取多个cell的写法,写过excel编程的不陌生
//                    $sheet->getHyperlink('J2:J' . (count($result2) + 1))->setUrl($item['url']);
//                }
//            });
//        })->export('xlsx');
//    }


    public $excel = [
[
null,
"7月29日   星期一",
"7月30日   星期二",
"7月31日   星期三",
"8月1日   星期四",
"8月2日   星期五",
"8月3日   星期六",
"8月4日   星期日"
],
[
null,
"台标  节目预告",
"台标  节目预告",
"台标  节目预告",
"台标  节目预告",
"台标  节目预告",
"台标  节目预告",
"台标  节目预告"
],
[
"6:50:00",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果"
],
[
"7:13:00",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖"
],
[
"7:45:00",
"轩辕剑之天之痕（8）",
"轩辕剑之天之痕（17）",
"轩辕剑之天之痕（26）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"8:36:00",
"轩辕剑之天之痕（9）",
"轩辕剑之天之痕（18）",
"轩辕剑之天之痕（27）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"9:38:00",
"轩辕剑之天之痕（10）",
"轩辕剑之天之痕（19）",
"轩辕剑之天之痕（28）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"10:38:00",
"轩辕剑之天之痕（11）",
"轩辕剑之天之痕（20）",
"轩辕剑之天之痕（29）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"11:39:00",
"轩辕剑之天之痕（12）",
"轩辕剑之天之痕（21）",
"轩辕剑之天之痕（30）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"12:30:00",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖"
],
[
"13:05:00",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果"
],
[
"13:40:00",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇"
],
[
"14:10:00",
"轩辕剑之天之痕（13）",
"轩辕剑之天之痕（22）",
"轩辕剑之天之痕（31）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"15:01:00",
"轩辕剑之天之痕（14）",
"轩辕剑之天之痕（23）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"16:01:00",
"轩辕剑之天之痕（15）",
"轩辕剑之天之痕（24）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"17:00:00",
"轩辕剑之天之痕（16）",
"轩辕剑之天之痕（25）",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传",
"射雕英雄传"
],
[
"17:33:00",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖",
"开心围脖"
],
[
"18:00:00",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果",
"开心果"
],
[
"18:34:05",
"我爱饭米粒第一季（159）",
"我爱饭米粒第一季（160）",
"我爱饭米粒第一季（161）",
"我爱饭米粒第一季（162）",
"我爱饭米粒第一季（163）",
"我爱饭米粒第一季（164）",
"我爱饭米粒第一季（165）"
],
[
null,
"风云大剧院",
"风云大剧院",
"风云大剧院",
"风云大剧院",
"风云大剧院",
"风云大剧院",
"风云大剧院"
],
[
"19:37:35",
"步步杀机（6）",
"步步杀机（8）",
"步步杀机（10）",
"步步杀机（12）",
"步步杀机（14）",
"步步杀机（16）",
"步步杀机（18）"
],
[
"20:32:35",
"步步杀机（7）",
"步步杀机（9）",
"步步杀机（11）",
"步步杀机（13）",
"步步杀机（15）",
"步步杀机（17）",
"步步杀机（19）"
],
[
"21:31:00",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇",
"天天惊奇"
],
[
"22:00:00",
"我爱看电影",
"我爱看电影",
"我爱看电影",
"我爱看电影",
"我爱看电影",
"我爱看电影",
"我爱看电影"
],
[
null,
"午夜剧院",
"午夜剧院",
"午夜剧院",
"午夜剧院",
"午夜剧院",
"午夜剧院",
"午夜剧院"
],
[
"1:00:00",
"水浒传",
"水浒传",
"水浒传",
"水浒传",
"水浒传",
"水浒传",
"水浒传"
],
[
"1:45:00",
"水浒传",
"水浒传",
"水浒传",
"水浒传",
"水浒传",
"水浒传",
"水浒传"
],
[
null,
"结束",
"结束",
"结束",
"结束",
"结束",
"结束",
"结束"
]
];


}