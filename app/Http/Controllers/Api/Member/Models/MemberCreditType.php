<?php

namespace App\Http\Controllers\Api\Member\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCreditType extends Model
{
    protected $table = 'member_credit_types';

    protected $guarded = [];

    public function scopeInUse($query){
        return $query->where('is_on', 1);
    }
}
