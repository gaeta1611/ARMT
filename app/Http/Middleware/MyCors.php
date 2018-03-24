<?php

namespace App\Http\Middleware;

use Closure;

class MyCors
{
    public function handle($request, Closure $next)
    {
        $http_origin = $_SERVER['HTTP_HOST'];

        if (!in_array($http_origin, ['armt.be','www.armt.be']))
        {
            $http_origin = 'https://www.armt.be';
        }


        return $next($request)
            ->header('Access-Control-Allow-Origin', $http_origin)
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
