<?php
namespace App\Post\Models;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model{
    protected $table = 'post';
    protected $guarded = [];
    protected $timestamps = true;
}