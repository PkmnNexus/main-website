<?php

use Livewire\Component;

new class extends Component {
    //
};

?>

<div class="mx-auto max-w-md px-6 py-12">

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">Member Login</h2>

    <p class="mt-2 text-sm text-gray-600">Sign in to your PkmnNexus account.</p>

    @if (session('status'))

        <div class="mt-4 rounded-sm bg-[var(--color-primary)] p-3 text-sm font-display font-bold text-white shadow-md">{{ session('status') }}</div>

    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">

        @csrf

        <div>

            <label for="email" class="mb-1 block text-sm font-bold">Email Address</label>

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

            <label for="password" class="mb-1 block text-sm font-bold">Password</label>

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

            <input type="checkbox" name="remember" value="1" class="rounded-sm">Remember me

        </label>

        <button type="submit"
                class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90">

            Sign In

        </button>

        @if (Route::has('password.request'))

            <p class="text-center text-sm">

                <a href="{{ route('password.request') }}" class="font-semibold text-[var(--color-primary)] hover:underline">

                    Forgot your password?

                </a>

            </p>

        @endif

    </form>

    @if (config('website.features.registration'))

        <p class="mt-6 text-center text-sm">

            Don't have an account yet?

            <a href="{{ route('register') }}" class="font-semibold text-[var(--color-primary)] hover:underline">

                Register here

            </a>

        </p>

    @endif

</div>