@if ($isEnabled() && $currentLanguage)

    <div x-data="{ open: false }"
         @click.outside="open = false"
         @keydown.escape.window="open = false"
         class="relative inline-flex ml-2 pl-2 border-l cursor-pointer border-l-gray-200 h-7 items-center">

        <button type="button"
                @click="open = !open"
                :aria-expanded="open.toString()"
                aria-label="Select language"
                class="inline-flex items-center rounded-md cursor-pointer transition-colors hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] dark:hover:bg-gray-800">

            @svg($currentLanguage['icon'], 'h-5 w-7 shrink-0')

        </button>

        <div x-cloak
             x-show="open"
             x-transition.origin.top.right
             class="absolute right-0 top-full z-50 mt-2 min-w-44 overflow-hidden rounded-lg border border-gray-200 bg-white py-1 shadow-lg dark:border-gray-700 dark:bg-gray-900"
             role="menu"
             aria-label="Available languages">

            <form action="{{ route('language.switch') }}" method="POST">

                @csrf

                @foreach ($locales as $locale => $language)

                    <button type="submit"
                            name="locale"
                            value="{{ $locale }}"
                            role="menuitem"
                            @click="open = false"
                            @if ($currentLocale === $locale)
                                aria-current="true"
                            @endif
                            class="flex w-full items-center gap-3 px-4 py-2 text-left cursor-pointer text-sm transition-colors {{ $currentLocale === $locale ? 'bg-gray-100 font-semibold text-[var(--color-primary)] dark:bg-gray-800' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-800' }}">

                        @svg($language['icon'], 'h-5 w-7 shrink-0')

                        <span>{{ $language['label'] }}</span>

                        @if ($currentLocale === $locale)

                            <svg class="ml-auto h-4 w-4"
                                 viewBox="0 0 20 20"
                                 fill="currentColor"
                                 aria-hidden="true">

                                <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.5 7.5a1 1 0 0 1-1.42 0l-3.5-3.5a1 1 0 1 1 1.414-1.414L8.5 12.086l6.79-6.79a1 1 0 0 1 1.414-.006Z" clip-rule="evenodd"/>

                            </svg>

                        @endif

                    </button>

                @endforeach

            </form>

        </div>

    </div>

@endif