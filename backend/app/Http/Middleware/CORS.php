<?php

namespace App\Http\Middleware;

use Closure;
//use function Symfony\Component\Debug\header;
use Symfony\Component\HttpFoundation\HeaderBag;
class CORS
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

        return $next($request)
        ->header('Access-Control-Allow-Origin','*')
        ->header('Access-Control-Allow-Credentials',true)
        ->header('Access-Control-Allow-Methods','GET, HEAD, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH')
        ->header('Access-Control-Allow-Headers','Content-Type,Authorization,X-Requested-With');
    }
}
