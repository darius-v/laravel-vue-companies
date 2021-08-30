<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsFix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        die('darius'); //todo remove
//        header("Access-Control-Allow-Origin: *");

        return $next($request);
    }
}
