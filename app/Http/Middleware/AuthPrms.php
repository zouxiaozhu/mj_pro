<?php

namespace App\Http\Middleware;
use App\Repository\Middleware\MiddlewareInterface\AuthPrmsInterface;
use Closure;

class AuthPrms
{
    public function __construct(AuthPrmsInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $check)
    {
        $check = explode('|',$check);
        $check_params =array_except($check,0);
        if ($ret = $this->auth->$check[0]($check_params) == 'false') {
            return abort(403);
        };
        return $next($request);
    }
}
