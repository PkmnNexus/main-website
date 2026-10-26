<div id="cookie-consent-banner"
     class="fixed inset-x-0 bottom-0 z-50 hidden p-4"
     role="region"
     aria-label="{{ __('general.cookie_preferences') }}">

    <div class="mx-auto max-w-5xl rounded-xl bg-white p-6 shadow-2xl">

        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">

            <div class="flex-1">

                <h2 class="font-display text-xl font-bold text-[var(--color-primary)]">{{ __('general.privacy_matters') }}</h2>

                <p class="mt-2 text-sm leading-relaxed text-[var(--color-secondary)]">{{ __('general.cookie_consent_description') }}</p>

                <a href="{{ route('page.cookie-policy') }}" class="mt-2 inline-block text-sm font-bold text-[var(--color-primary)] underline underline-offset-2">{{ __('general.read_cookie_policy') }}</a>

            </div>

            <div class="flex flex-col gap-2 sm:flex-row md:flex-col">

                <button type="button"
                        id="cookie-accept-all"
                        class="cursor-pointer rounded-lg bg-[var(--color-primary)] px-5 py-3 text-sm font-bold text-white transition hover:opacity-90">

                    {{ __('general.accept_all') }}

                </button>

                <button type="button"
                        id="cookie-reject-optional"
                        class="cursor-pointer rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-bold text-[var(--color-secondary)] transition hover:bg-gray-100">

                    {{ __('general.reject_optional') }}

                </button>

                <button type="button"
                        id="cookie-open-settings"
                        class="cursor-pointer px-3 py-2 text-sm font-bold text-[var(--color-secondary)] underline underline-offset-2"
                        aria-expanded="false"
                        aria-controls="cookie-settings">

                    {{ __('general.cookie_settings') }}

                </button>

            </div>

        </div>

        <div id="cookie-settings" class="mt-5 hidden border-t border-gray-200 pt-5">

            <h3 class="font-display text-lg font-bold text-[var(--color-secondary)]">{{ __('general.cookie_settings') }}</h3>

            <div class="mt-4 flex flex-col gap-4">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="font-bold text-sm text-[var(--color-secondary)]">{{ __('general.necessary_storage') }}</p>

                        <p class="mt-1 text-sm text-gray-600">{{ __('general.necessary_storage_description') }}</p>

                    </div>

                    <span class="shrink-0 text-sm font-bold text-[var(--color-secondary)]">{{ __('general.always_active') }}</span>

                </div>

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <label for="cookie-analytics" class="font-bold text-sm text-[var(--color-secondary)]">{{ __('general.analytics') }}</label>

                        <p class="mt-1 text-sm text-gray-600">{{ __('general.analytics_description') }}</p>

                    </div>

                    <input type="checkbox" id="cookie-analytics" class="mt-1 h-5 w-5 rounded border-gray-300 accent-[var(--color-primary)]">

                </div>

            </div>

            <button type="button"
                    id="cookie-save-settings"
                    class="cursor-pointer mt-5 rounded-lg bg-[var(--color-primary)] px-5 py-3 text-sm font-bold text-white transition hover:opacity-90">

                {{ __('general.save_preferences') }}

            </button>

        </div>

    </div>

</div>