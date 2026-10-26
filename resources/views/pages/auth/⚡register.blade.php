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

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">{{ __('general.create_account_heading') }}</h2>

    <p class="mt-2 text-sm text-gray-600">{{ __('general.create_account_description') }}</p>

    <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-5">

        @csrf

        <div>

            <label for="name" class="mb-1 block text-sm font-bold">{{ __('general.first_name') }}</label>

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

            <label for="surname" class="mb-1 block text-sm font-bold">{{ __('general.last_name_optional') }}</label>

            <input id="surname"
                   name="surname"
                   type="text"
                   value="{{ old('surname') }}"
                   autocomplete="family-name"
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

            @error('surname')

                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

            @enderror

        </div>

        <div>

            <label for="display_name" class="mb-1 block text-sm font-bold">{{ __('general.display_name') }}</label>

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

            <label for="email" class="mb-1 block text-sm font-bold">{{ __('general.email_address') }}</label>

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

            <label for="password" class="mb-1 block text-sm font-bold">{{ __('general.password') }}</label>

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

            <label for="password_confirmation" class="mb-1 block text-sm font-bold">{{ __('general.confirm_password') }}</label>

            <input id="password_confirmation"
                   name="password_confirmation"
                   type="password"
                   autocomplete="new-password"
                   required
                   class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-[var(--color-primary)] focus:outline-none">

        </div>

        <button type="submit" class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90">

            {{ __('general.create_account_button') }}

        </button>

        <p class="text-center text-sm">

            {{ __('general.already_have_account') }}

            <a href="{{ route('login') }}" class="font-semibold text-[var(--color-primary)] hover:underline">{{ __('general.sign_in') }}</a>

        </p>

    </form>

</div>