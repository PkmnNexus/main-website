@if (config('website.features.member_login'))

    @php
        $locale = app()->getLocale();

        $profileRoute = $locale === config('localization.default', 'en')
            ? 'account.profile'
            : 'account.profile.' . $locale;

        $user = auth()->user();

        $avatarUrl = $user
            ? ($user->getFirstMediaUrl('user_avatar') ?: asset('images/default_avatar.png'))
            : null;
    @endphp

    <div
        x-data="{ avatarUrl: @js($avatarUrl) }"
        x-on:profile-updated.window="
            avatarUrl = $event.detail.avatarUrl || avatarUrl;
        "
        class="inline-flex items-center ml-2 pl-1 border-l border-l-gray-200"
    >

        <a href="{{ auth()->check() ? route($profileRoute) : route('login') }}"
           aria-label="{{ auth()->check() ? 'View your member profile' : 'Login to your member account' }}"
           title="Member area"
           class="inline-flex items-center justify-center hover:!text-[var(--color-primary)] transition-colors duration-200">

            @if (auth()->check())

                <img
                    :src="avatarUrl"
                    src="{{ $avatarUrl }}"
                    alt="{{ auth()->user()->display_name }}'s avatar"
                    width="48"
                    height="48"
                    class="block w-7 h-7 shrink-0 rounded-sm object-cover ml-1"
                >

            @else

                <x-heroicon-o-user-circle class="w-7 h-7 text-[var(--color-secondary)] hover:!text-[var(--color-primary)] transition-colors duration-200" />

            @endif

        </a>

        @auth

            <form method="POST" action="{{ route('logout') }}" class="ml-2 flex items-center cursor-pointer">

                @csrf

                <button type="submit"
                        aria-label="Log out"
                        title="Log out"
                        class="inline-flex items-center cursor-pointer justify-center text-[var(--color-secondary)] hover:!text-[var(--color-primary)] transition-colors duration-200">

                    <x-heroicon-o-arrow-right-on-rectangle class="w-6 h-6" />

                </button>

            </form>

        @endauth

    </div>

@endif