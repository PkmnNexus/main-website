<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class EnsureAccountIsActive
{
    /**
     * Ensure the account is active and not suspended before authentication.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $username = Fortify::username();

        $user = User::where($username, $request->input($username))->first();

        if (! $user) {
            return $next($request);
        }

        if ($user->isSuspended()) {
            $message = $user->suspended_until
                ? 'Your account is temporarily suspended until '.$user->suspended_until->format('F j, Y \a\t H:i').'. Please contact support if you need assistance.'
                : 'Your account is suspended. Please contact support if you need assistance.';

            throw ValidationException::withMessages([
                $username => $message,
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                $username => 'Your account is inactive. Please contact support if you need assistance.',
            ]);
        }

        return $next($request);
    }
}