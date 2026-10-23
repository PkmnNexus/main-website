<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Ensure the authenticated account is active and not suspended.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->isSuspended()) {
            $message = $user->suspended_until
                ? 'Your account is temporarily suspended until '.$user->suspended_until->format('F j, Y \a\t H:i').'. Please contact support if you need assistance.'
                : 'Your account is suspended. Please contact support if you need assistance.';

            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors(['email' => $message]);
        }

        if (! $user->is_active) {
            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account is inactive. Please contact support if you need assistance.',
                ]);
        }

        return $next($request);
    }
}