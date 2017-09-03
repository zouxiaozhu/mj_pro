<?php
namespace App\Post\Providers;

use App\Post\Repositories\Forum;
use App\Post\Repositories\ForumRepositoryInterface;
use App\Post\Repositories\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Post\Repositories\Post;

class PostServiceProvider extends ServiceProvider{
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       app()->bind(ForumRepositoryInterface::class,Forum::class);
       app()->bind(PostRepositoryInterface::class,Post::class);
    }


}