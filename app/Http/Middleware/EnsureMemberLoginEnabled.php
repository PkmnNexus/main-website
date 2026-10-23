<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMemberLoginEnabled
{
    /**
     * Ensure frontend member login is enabled.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->is('login')
            && ! config('website.features.member_login')
        ) {
            abort(404);
        }

        return $next($request);
    }
}