<?php
namespace  App;
class Product{
   public $price;
    public function __construct($name,$price)
    {
        $this->price= $price;
        $this->name = $name;
    }
    public function setDiscount($discount){
        $this->price*=$discount/100;
    }

}