<?php

use Livewire\Component;

new class extends Component {
    //
};

?>

<div class="mx-auto max-w-md px-6 py-12">

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">{{ __('general.reset_password_heading') }}</h2>

    <p class="mt-2 text-sm text-gray-600">{{ __('general.reset_password_description') }}</p>

    @if (session('status'))

        <div class="mt-4 rounded-sm bg-[var(--color-primary)] p-3 text-sm font-display font-bold text-white shadow-md">{{ session('status') }}</div>

    @endif

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">

        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div>

            <label for="email" class="mb-1 block text-sm font-bold">{{ __('general.email_address') }}</label>

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
                messages: {
                    minLength: @js(__('general.password_rule_min_length', ['count' => 12])),
                    uppercase: @js(__('general.password_rule_uppercase')),
                    lowercase: @js(__('general.password_rule_lowercase')),
                    number: @js(__('general.password_rule_number')),
                    specialCharacter: @js(__('general.password_rule_special_character')),
                },
                get checks() {
                    return [
                        { label: this.messages.minLength, valid: this.password.length >= 12 },
                        { label: this.messages.uppercase, valid: /[A-Z]/.test(this.password) },
                        { label: this.messages.lowercase, valid: /[a-z]/.test(this.password) },
                        { label: this.messages.number, valid: /[0-9]/.test(this.password) },
                        { label: this.messages.specialCharacter, valid: /[^A-Za-z0-9]/.test(this.password) },
                    ];
                }
            }"
        >

            <label for="password" class="mb-1 block text-sm font-bold">{{ __('general.new_password') }}</label>

            <input id="password"
                   name="password"
                   type="password"
                   autocomplete="new-password"
                   required
                   x-model="password"
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            <div x-show="password.length > 0" x-cloak class="mt-3 rounded-sm border border-gray-200 p-3">

                <p class="mb-2 text-sm font-bold">{{ __('general.password_requirements') }}</p>

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
                    {{ __('general.password_meets_all_requirements') }}
                </p>

            </div>

            @error('password')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div>

            <label for="password_confirmation" class="mb-1 block text-sm font-bold">{{ __('general.confirm_new_password') }}</label>

            <input id="password_confirmation"
                   name="password_confirmation"
                   type="password"
                   autocomplete="new-password"
                   required
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

        </div>

        <button type="submit" class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90">

            {{ __('general.reset_password_button') }}

        </button>

        <p class="text-center text-sm">

            {{ __('general.remember_password') }}

            <a href="{{ route('login') }}" class="font-semibold text-[var(--color-primary)] hover:underline">

                {{ __('general.sign_in') }}

            </a>

        </p>

    </form>

</div>