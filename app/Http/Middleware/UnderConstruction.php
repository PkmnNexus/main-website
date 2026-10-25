<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

class UnderConstruction
{
    public function handle(Request $request, Closure $next)
    {
        if (! config('website.under_construction')) {
            return $next($request);
        }

        $ip = $request->ip();
        $allowedIps = config('website.whitelist', []);

        foreach ($allowedIps as $allowedIp) {
            if ($ip && IpUtils::checkIp($ip, $allowedIp)) {
                return $next($request);
            }
        }

        if ($request->routeIs('under-construction')) {
            return $next($request);
        }

        return redirect()->route('under-construction');
    }
}