<?php
namespace App\Http\Middleware;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/7
 * Time: 17:18
 */
use Closure;
use Illuminate\Support\Facades\Redirect;

class AdminAuthMiddleware{

    public function handle($request, Closure $next, $guard = null)
    {
//        var_export(auth()->user()->id);die;
        if (!(auth()->user()) OR !(auth()->user()->id)) {
            return Redirect::to('api/service/in');
        }

        return $next($request);
    }


}