<?php
namespace App\Http\Controllers\Api\Internal;
trait CommonTrait{
    public function arrayFilter($array = [], $column = ''){
         $new_array = array_filter(array_unique($array));
         if ( !$column) {
            return $new_array;
         }

         return array_column($new_array, $column);
    }

}