<?php
namespace Zfile;
use Illuminate\Support\Facades\Facade;

class ZMedia extends Facade{
    public static function getFacadeAccessor()
    {
       return 'zmedia';
    }
    
}