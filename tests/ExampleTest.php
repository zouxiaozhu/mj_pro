<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends \TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     *
     * /** @test
     */
//    public function testBasicExample()
//    {
//        //$pro = new Product();
//
//        $product =new App\Product();
//        return $this->assertEquals('iphone 7',$product->name());
//    }
    /** @test */
    public function names_color()
    {
        $product = new App\Product(11, 11);
        return $this->assertEquals(10000, $product->price);

    }

    /** @test */
    public function product_can_be_discount()
    {
        $product = new App\Product('Macbook', 10000);
        $product->setDiscount(80);
        $this->assertEquals(8000, $product->price);
    }
}
