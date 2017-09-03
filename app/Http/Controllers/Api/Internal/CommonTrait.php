<?php
namespace App\Http\Controllers\Api\Internal;
trait CommonTrait{
    public function arrayFilter($array){
        return array_filter(array_unique($array));
    }


}