<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use \Closure;

class JsonMiddleware
{

    public function handle($request, Closure $next)
    {
        // Force Json accept type
        if (!Str::contains($request->header('accept'), ['/json', '+json'])) {
            $request->headers->set('accept', 'application/json,' . $request->header('accept'));
        }

        // Force Json accept type
        if (!Str::contains($request->header('x-requested-with'), ['XMLHttpRequest'])) {
            $request->headers->set('x-requested-with', 'XMLHttpRequest');
        }

        return $next($request);
    }
}
