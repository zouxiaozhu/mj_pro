<?php

namespace App\Http\Controllers\Api\Member\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSession extends Model
{
    protected $primaryKey = 'token';

    protected $table = 'member_sessions';

    protected $guarded = [];
}
