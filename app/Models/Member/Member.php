<?php

namespace App\Models\Member;

use App\Models\Package\MemberPackage;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member_members';
    public $guarded = [];

    public function package()
    {
        return $this->hasMany(MemberPackage::class, 'member_id', 'id');
    }
}