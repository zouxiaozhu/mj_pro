<?php

/**
 * Created by PhpStorm.
 * User: jiuji
 * Date: 2017/6/16
 * Time: 下午2:34
 */
namespace Tests\unit;
use App\Product;
use App\Order;
class OrderTest extends \TestCase
{
    protected $order;
    public function setUp()
    {
        $order = new Order();
        $product = new Product('iwatch',3000);
        $productMdr = new Product('MDR',2000);

    }
    /** @test */
    public function orderContsistsProduct()
    {
        $order->add($product);
        $order->add($productMdr);

        $this->assertCount(2,$order->products());
    }

    /** @test */
    public function totalCostFromAllProducts(){

        $order->add($product);
        $order->add($productMdr);

        $this->assertEquals(5000,$this->total());
    }
}
