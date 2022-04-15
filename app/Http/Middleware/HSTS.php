<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HSTS
{

    public function handle(Request $request, Closure $next)
    {
        //Include HSTS
        $response = $next($request);

        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubdomains');

        return $response;
    }

}