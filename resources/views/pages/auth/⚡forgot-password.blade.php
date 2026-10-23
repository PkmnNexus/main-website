<?php

use Livewire\Component;

new class extends Component {
    //
};

?>

<div class="mx-auto max-w-md px-6 py-12">

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">Forgot Your Password?</h2>

    <p class="mt-2 text-sm text-gray-600">Enter your email address and we'll send you a password reset link.</p>

    @if (session('status'))

        <div class="mt-4 rounded-sm bg-[var(--color-primary)] p-3 text-sm font-display font-bold text-white shadow-md">{{ session('status') }}</div>

    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">

        @csrf

        <div>

            <label for="email" class="mb-1 block text-sm font-bold">Email Address</label>

            <input id="email"
                   name="email"
                   type="email"
                   value="{{ old('email') }}"
                   autocomplete="email"
                   required
                   autofocus
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('email')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <button type="submit" class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90">

            Send Password Reset Link

        </button>

        <p class="text-center text-sm">

            Remember your password?

            <a href="{{ route('login') }}" class="font-semibold text-[var(--color-primary)] hover:underline">

                Sign In

            </a>

        </p>

    </form>

</div>