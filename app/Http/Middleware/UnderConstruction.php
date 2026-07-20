<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UnderConstruction
{
    public function handle(Request $request, Closure $next)
    {
        if (! config('site.under_construction')) {
            return $next($request);
        }

        $allowedIps = config('website.whitelist');

        if (in_array($request->ip(), $allowedIps)) {
            return $next($request);
        }

        if ($request->routeIs('under-construction')) {
            return $next($request);
        }

        return redirect()->route('under-construction');
    }
}
