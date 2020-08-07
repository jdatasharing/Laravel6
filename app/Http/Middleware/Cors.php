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
    $allowedOrigins = [
        'http://localhost:3000',
    ];
    $requestOrigin = $request->headers->get('origin');

    if (in_array($requestOrigin, $allowedOrigins)) {
          header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
            return $next($request);
    }

    return $next($request);
}
}
