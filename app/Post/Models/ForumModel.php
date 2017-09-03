<?php
namespace App\Post\Models;
use Illuminate\Database\Eloquent\Model;
class ForumModel extends Model{
    protected $table = 'forums';
    protected $guarded = [];
    public $timestamps = true;
}