<?php

namespace App\Http\Controllers\Api\Member\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSMS extends Model
{
    protected $table = 'member_sms_server';

    protected $guarded = [];

    public function scopeInUse($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrderByOver($query)
    {
        return $query->orderBy('over', 'DESC');
    }
}
