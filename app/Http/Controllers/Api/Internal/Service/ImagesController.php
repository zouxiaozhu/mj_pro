<?php
/**
 * Created by PhpStorm.
 * User: jiuji
 * Date: 2017/6/13
 * Time: 上午9:42
 */
namespace App\Http\Controllers\Api\Internal\Service;

use App\Http\Controllers\Controller;
use App\Models\WaterSetting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class ImagesController extends Controller
{
    protected $image_type = ['jpg', 'jpeg', 'png', 'bmp'];

    public function image(Request $request)
    {   //上传原图
        $MOUDLE = '/aaa';
        $time   = Carbon::now()->timestamp;
        $file   = $request->file('file');
        $ext    = $file->getClientOriginalExtension();
        $upload_image_name   = $time . mt_rand(0, 10000) .$file->getClientOriginalName();
        $file->move(env('FILE_STORAGE_PATH') . $MOUDLE,$upload_image_name);
        $image_path       = env('FILE_STORAGE_PATH') . $MOUDLE . '/' . $upload_image_name;
        $water            = WaterSetting::where('is_use', 1)->first();
        $water_image_path = $this->water($image_path, $water);
        return $water_image_path;
    }

    public function water($image_path, WaterSetting $water)
    {
        is_dir('/Users/jiuji/Water/')
        $water_image_path = '/Users/jiuji/Water/' . Carbon::now()->timestamp . mt_rand(0, 100) . '.jpg';
        $img              = Image::make($image_path)->resize($water->width, $water->height)->insert($water->water_path, 'bottom-right', $water->mag_top, $water->mag_left)->save($water_image_path);

        return $water_image_path;
    }

}

