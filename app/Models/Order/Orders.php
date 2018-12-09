<?php
/**
 * Created by PhpStorm.
 * User: lzhang
 * Date: 18-10-21
 * Time: 下午4:00
 * Email: lzhang@che300.com
 */

namespace App\Models\Order;

use App\Models\Member\Member;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'member_order';

    protected $guarded = [];

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

}