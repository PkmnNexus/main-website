<?php

use Livewire\Component;

new class extends Component {
    //
};

?>

<div class="mx-auto max-w-md px-6 py-12">

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">Reset Your Password</h2>

    <p class="mt-2 text-sm text-gray-600">Enter your new password below to reset your account password.</p>

    @if (session('status'))

        <div class="mt-4 rounded-sm bg-[var(--color-primary)] p-3 text-sm font-display font-bold text-white shadow-md">{{ session('status') }}</div>

    @endif

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">

        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div>

            <label for="email" class="mb-1 block text-sm font-bold">Email Address</label>

            <input id="email"
                   name="email"
                   type="email"
                   value="{{ old('email', request()->query('email')) }}"
                   autocomplete="email"
                   required
                   autofocus
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('email')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div
            x-data="{
                password: '',
                get checks() {
                    return [
                        { label: 'At least 12 characters', valid: this.password.length >= 12 },
                        { label: 'At least one uppercase letter', valid: /[A-Z]/.test(this.password) },
                        { label: 'At least one lowercase letter', valid: /[a-z]/.test(this.password) },
                        { label: 'At least one number', valid: /[0-9]/.test(this.password) },
                        { label: 'At least one special character', valid: /[^A-Za-z0-9]/.test(this.password) },
                    ];
                }
            }"
        >

            <label for="password" class="mb-1 block text-sm font-bold">New Password</label>

            <input id="password"
                   name="password"
                   type="password"
                   autocomplete="new-password"
                   required
                   x-model="password"
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            <div x-show="password.length > 0" x-cloak class="mt-3 rounded-sm border border-gray-200 p-3">

                <p class="mb-2 text-sm font-bold">Password requirements</p>

                <ul class="space-y-1">

                    <template x-for="check in checks" :key="check.label">

                        <li class="flex items-center gap-2 text-sm"
                            :class="check.valid ? 'text-green-700' : 'text-gray-500'">

                            <span x-text="check.valid ? '✓' : '○'" aria-hidden="true"></span>

                            <span x-text="check.label"></span>

                        </li>

                    </template>

                </ul>

                <p x-show="checks.every(check => check.valid)"
                   x-cloak
                   class="mt-2 text-sm font-bold text-green-700">
                    Your password meets all requirements.
                </p>

            </div>

            @error('password')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div>

            <label for="password_confirmation" class="mb-1 block text-sm font-bold">Confirm New Password</label>

            <input id="password_confirmation"
                   name="password_confirmation"
                   type="password"
                   autocomplete="new-password"
                   required
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

        </div>

        <button type="submit" class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90">

            Reset Password

        </button>

        <p class="text-center text-sm">

            Remember your password?

            <a href="{{ route('login') }}" class="font-semibold text-[var(--color-primary)] hover:underline">

                Sign In

            </a>

        </p>

    </form>

</div>