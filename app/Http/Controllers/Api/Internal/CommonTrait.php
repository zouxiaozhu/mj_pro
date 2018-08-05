<?php
namespace App\Http\Controllers\Api\Internal;
trait CommonTrait{
    public function arrayFilter($array = [], $column = '',$return_by_field= false) {
         $new_array = array_filter(($array));
         if ( ! $column) {
            return $new_array;
         }

         if ( ! $return_by_field) {
             return array_column($new_array, $column);
         }

        return array_column($new_array, null, $column);
    }

}