<?php

namespace App\Http\Middleware;

use Closure;

class BeforeGlobalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //code here
        
        return $next($request);
    }
}
