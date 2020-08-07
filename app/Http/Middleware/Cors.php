<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
     
       header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
            return $next($request);

    // $allowedOrigins = [
    //     'http://localhost:3000',
    //     'http://192.168.0.5:4002/'
    // ];
    // $requestOrigin = $request->headers->get('origin');

    // if (in_array($requestOrigin, $allowedOrigins)) {
    //     return $next($request)
    //         ->header('Access-Control-Allow-Origin', $requestOrigin)
    //         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
    //         ->header('Access-Control-Allow-Credentials', 'true')
    //         ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    

}
}
