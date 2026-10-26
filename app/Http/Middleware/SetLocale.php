<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $default = config('localization.default', 'en');
        $locales = array_keys(config('localization.locales', []));

        if (config('localization.enabled', false)) {
            $locale = $request->route('locale', $request->session()->get('locale', $default));

            if (! in_array($locale, $locales, true)) {
                abort(404);
            }

            $request->session()->put('locale', $locale);

            URL::defaults(['locale' => $locale]);

            $request->route()->forgetParameter('locale');
        } else {
            $locale = $default;
        }

        if (! in_array($locale, $locales, true)) {
            $locale = $default;
        }

        App::setLocale($locale);

        return $next($request);
    }
}