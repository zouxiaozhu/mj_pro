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

class Package extends Model{
    protected $table = 'packages';
    protected $guarded = [];

    public function scopeMemberPkg()
    {
        return $this->hasMany(MemberPackage::class, 'package_id', 'id');
    }
}