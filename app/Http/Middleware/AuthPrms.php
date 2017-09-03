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
    public function handle($request, Closure $next, $permissions)
    {
        if ($this->auth->verifyPrms($permissions)) {
            return $next($request);
        }
       return abort(403);
    }
}
