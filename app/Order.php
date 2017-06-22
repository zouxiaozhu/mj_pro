<?php
/**
 * Created by PhpStorm.
 * User: jiuji
 * Date: 2017/6/16
 * Time: 下午2:44
 */

namespace App;


class Order
{
    protected $products =[];
    public function add(Product $product)
    {
        $this->products[] = $product;
    }

    public function products(){
        return $this->products;
    }


    public function total(){
        $total = 0;
        foreach ($this->products as $product){


        }

    }


}