<?php

namespace App\Http\Controllers\Api\Member\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCreditRule extends Model
{
    protected $table = 'member_credit_rules';

    protected $guarded = [];

    public function scopeInUse($query){
        return $query->where('status', 1);
    }
}
