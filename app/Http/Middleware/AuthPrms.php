<?php

namespace App\Http\Middleware;

use App\Repository\MjInterface\AuthInterface;
use Closure;

class AuthPrms
{
    public function __construct(AuthInterface $auth)
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
        if ($ret = $this->auth->check($check) == 'false') {
            return abort(403);
        };
        return $next($request);
    }
}
