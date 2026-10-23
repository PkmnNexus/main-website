<?php

use Livewire\Component;

new class extends Component {
    public string $passwordFeedback = '';

    public function updatedPasswordFeedback(): void
    {
        //
    }
};

?>

<div class="mx-auto max-w-md px-6 py-12">

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">Create an Account</h2>

    <p class="mt-2 text-sm text-gray-600">Join the PkmnNexus community.</p>

    <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-5">

        @csrf

        <div>

            <label for="name" class="mb-1 block text-sm font-bold">First Name</label>

            <input id="name"
                   name="name"
                   type="text"
                   value="{{ old('name') }}"
                   autocomplete="given-name"
                   required
                   autofocus
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('name')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div>

            <label for="surname" class="mb-1 block text-sm font-bold">Last Name</label>

            <input id="surname"
                   name="surname"
                   type="text"
                   value="{{ old('surname') }}"
                   autocomplete="family-name"
                   required
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('surname')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div>

            <label for="display_name" class="mb-1 block text-sm font-bold">Display Name</label>

            <input id="display_name"
                   name="display_name"
                   type="text"
                   value="{{ old('display_name') }}"
                   autocomplete="nickname"
                   required
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('display_name')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div>

            <label for="email" class="mb-1 block text-sm font-bold">Email Address</label>

            <input id="email"
                   name="email"
                   type="email"
                   value="{{ old('email') }}"
                   autocomplete="email"
                   required
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

            <label for="password" class="mb-1 block text-sm font-bold">Password</label>

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

            <label for="password_confirmation" class="mb-1 block text-sm font-bold">Confirm Password</label>

            <input id="password_confirmation"
                   name="password_confirmation"
                   type="password"
                   autocomplete="new-password"
                   required
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

        </div>

        <button type="submit" class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90">

            Create Account

        </button>

        <p class="text-center text-sm">

            Already have an account?

            <a href="{{ route('login') }}" class="font-semibold text-[var(--color-primary)] hover:underline">Sign in</a>

        </p>

    </form>

</div>