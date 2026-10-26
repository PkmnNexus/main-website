<?php

use Livewire\Component;

new class extends Component {
    //
};

?>

<div class="mx-auto max-w-md px-6 py-12">

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">{{ __('general.member_login') }}</h2>

    <p class="mt-2 text-sm text-gray-600">{{ __('general.sign_in_to_account') }}</p>

    @if (session('status'))

        <div class="mt-4 rounded-sm bg-[var(--color-primary)] p-3 text-sm font-display font-bold text-white shadow-md">{{ session('status') }}</div>

    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">

        @csrf

        <div>

            <label for="email" class="mb-1 block text-sm font-bold">{{ __('general.email_address') }}</label>

            <input id="email"
                   name="email"
                   type="email"
                   value="{{ old('email') }}"
                   autocomplete="username"
                   required
                   autofocus
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('email')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div>

            <label for="password" class="mb-1 block text-sm font-bold">{{ __('general.password') }}</label>

            <input id="password"
                   name="password"
                   type="password"
                   autocomplete="current-password"
                   required
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('password')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <label class="flex items-center gap-2 text-sm">

            <input type="checkbox" name="remember" value="1" class="rounded-sm">{{ __('general.remember_me') }}

        </label>

        <button type="submit"
                class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90">

            {{ __('general.sign_in') }}

        </button>

        @if (Route::has('password.request'))

            <p class="text-center text-sm">

                <a href="{{ route('password.request') }}" class="font-semibold text-[var(--color-primary)] hover:underline">

                    {{ __('general.forgot_your_password') }}

                </a>

            </p>

        @endif

    </form>

    @if (config('website.features.registration'))

        <p class="mt-6 text-center text-sm">

            {{ __('general.dont_have_account_yet') }}

            <a href="{{ route('register') }}" class="font-semibold text-[var(--color-primary)] hover:underline">

                {{ __('general.register_here') }}

            </a>

        </p>

    @endif

</div>