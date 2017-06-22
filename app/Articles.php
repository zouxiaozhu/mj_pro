<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    public function scopeTrending($query)
    {
        return $query->orderBy('reads','desc')->get();
    }
}
