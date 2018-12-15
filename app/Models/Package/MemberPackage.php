<?php
/**
 * Created by PhpStorm.
 * User: lzhang
 * Date: 18-9-24
 * Time: 上午11:28
 * Email: lzhang@che300.com
 */

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Model;

class MemberPackage extends Model
{
    protected $table = 'member_package';
    protected $guarded = [];

    public function scopePackage()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }
}