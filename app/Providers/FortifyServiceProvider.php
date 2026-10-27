<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\EnsureAccountIsActive;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\Page;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
        $this->configureAuthenticationPipeline();
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn () => view('frontend.auth.login', [
            'pageSeo' => Page::where('slug', 'login')
                ->where('is_active', true)
                ->firstOrFail(),
        ]));

        Fortify::registerView(function () {
            abort_unless(config('website.features.registration'), 404);

            return view('frontend.auth.register', [
                'pageSeo' => Page::where('slug', 'register')
                    ->where('is_active', true)
                    ->firstOrFail(),
            ]);
        });

        Fortify::verifyEmailView(fn () => view('frontend.auth.verify-email', [
            'pageSeo' => Page::where('slug', 'verify-email')
                ->where('is_active', true)
                ->firstOrFail(),
        ]));

        Fortify::resetPasswordView(fn () => view('frontend.auth.reset-password', [
            'pageSeo' => Page::where('slug', 'reset-password')
                ->where('is_active', true)
                ->firstOrFail(),
        ]));

        Fortify::requestPasswordResetLinkView(fn () => view('frontend.auth.forgot-password', [
            'pageSeo' => Page::where('slug', 'forgot-password')
                ->where('is_active', true)
                ->firstOrFail(),
        ]));

        Fortify::twoFactorChallengeView(fn () => view('livewire.auth.two-factor-challenge'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip(),
            );
        });
    }

    /**
     * Configure the authentication pipeline.
     */
    private function configureAuthenticationPipeline(): void
    {
        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                EnsureLoginIsNotThrottled::class,
                config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
                EnsureAccountIsActive::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });
    }
}