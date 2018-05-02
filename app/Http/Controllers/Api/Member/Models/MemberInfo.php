<?php

namespace App\Http\Controllers\Api\Member\Models;

use Illuminate\Database\Eloquent\Model;

class MemberInfo extends Model
{
    protected $table = 'member_info';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at', 'id'];
}
