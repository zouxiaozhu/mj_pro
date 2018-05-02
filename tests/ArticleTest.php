<?php
/**
 * Created by PhpStorm.
 * User: jiuji
 * Date: 2017/6/16
 * Time: 下午3:10
 */
namespace  Tests\Unit;
use App\Articles;


class ExampleTest extends \TestCase
{

/** @test */
    public function trendingArticles()
    {
        $id = 1;
        $this->visit('api/auth/role')->dontsee('xx');
          ;

    //use Illuminate\Foundation\Testing\DatabaseTransactions;
//        factory(Articles::class,3)->create();
//        factory(Articles::class,1)->create(['reads'=>10]);
//        $mostp = factory(Articles::class,999999999)->create(['reads'=>20]);
//
//        $articles = Articles::trending();
//        $this->assertEquals($mostp->id,$articles->first()->id);
    }

}