<?php

namespace App\Http\Controllers\Api\Member\Models;

use Illuminate\Database\Eloquent\Model;

class MemberPlatform extends Model
{
    protected $table = 'member_platforms';

    protected $guarded = [];

    protected $hidden = ['id', 'created_at', 'updated_at', 'creator', 'creator_id'];

    public function scopeInUse($query)
    {
        return $query->where('status', 1);
    }

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }
}
