<header x-data="{ open: false }"
        @keydown.escape.window="open = false"
        @close-menu.window="open = false"
        class="flex flex-col">

    <div class="mobile-social-top bg-(--color-primary)">

        <div class="flex lg:hidden max-w-lg md:max-w-5xl xl:max-w-6xl mx-auto px-6 py-3 2xl:px-0 justify-end items-center h-full w-full">

            <x-social-media 
                size="icon-sm"
            />

        </div>

    </div>

    <div class="main-navigation-wrapper">

        <div class="main-navigation flex max-w-lg md:max-w-5xl xl:max-w-6xl mx-auto px-6 xl:px-0 h-full w-full">

            <div class="flex md:hidden w-1/2">

                <button 
                    @click="open = true"
                    class="self-center bg-[var(--color-primary)] text-white p-2 rounded-md"
                    aria-label="Open mobile menu"
                    :aria-expanded="open.toString()"
                >

                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                </button>

            </div>

            <nav class="hidden md:flex h-full justify-between items-center w-1/2 lg:w-1/3"
                 role="navigation" 
                 aria-label="Main navigation"
                 itemscope 
                 itemtype="https://schema.org/SiteNavigationElement"
            >

                <ul class="flex items-center font-display font-bold uppercase text-[var(--color-secondary)] text-sm space-x-1">
                    @foreach (config('navigation.main') as $item)
                    
                        @php
                            $isActive = collect($item['active_routes'] ?? [$item['route']])
                                ->contains(fn ($pattern) => request()->routeIs($pattern));
                        @endphp

                        <li itemprop="name">
                            <a 
                                href="{{ route($item['route']) }}"
                                itemprop="url"
                                class="px-4 py-2 rounded-sm transition-colors duration-200
                                {{ $isActive 
                                    ? 'bg-[var(--color-primary)] text-white' 
                                    : 'text-[var(--color-secondary)] hover:text-[var(--color-primary)]' }}">
                                
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

            </nav>

            <div class="flex justify-end lg:justify-center items-center w-1/2 lg:w-1/3">

                <a href="{{ route('home') }}">
                    <figure>
                        <img src="{{ asset('images/PkmnNexus-Logo.svg') }}" 
                             alt="Logo PkmnNexus" 
                             class="h-8 w-auto"/>
                    </figure>
                </a>

            </div>

            <div class="hidden lg:flex justify-end items-center w-1/3">

                <x-social-media />

            </div>

        </div>

    </div>

    {{-- BACKDROP --}}
    <div 
        x-show="open"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 bg-[var(--color-primary)]/50 z-40"
        @click="open = false"
        role="presentation"
        aria-hidden="true"
    ></div>

    {{-- MOBILE MENU --}}
    <div 
        x-show="open"
        x-cloak
        @click.outside="open = false"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-3/4 max-w-sm h-full bg-white z-50 shadow-[-12px_0_30px_rgba(0,0,0,0.2)]"
        role="dialog"
        aria-modal="true"
        aria-label="Mobile menu"
    >

        <div class="flex items-center justify-between p-4">

            <a href="{{ route('home') }}">
                <img 
                    src="{{ asset('images/pkmninsider-logo.svg') }}" 
                    alt="Logo PkmnInsider"
                    class="h-8 w-auto"
                />
            </a>

            <button 
                @click="open = false"
                class="bg-[var(--color-primary)] text-white p-2 rounded-md 
                    hover:opacity-90 transition-all duration-200"
                aria-label="Close mobile menu"
            >
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>

        <nav class="mobile-menu w-full" aria-label="Mobile navigation">

            <ul class="font-display font-bold uppercase text-[var(--color-secondary)]">

                @foreach (config('navigation.main') as $item)
                    <li>
                        <a 
                            href="{{ route($item['route']) }}"
                            class="w-full flex px-4 py-3 
                                {{ request()->routeIs($item['route']) 
                                    ? 'bg-[var(--color-primary)] text-white' 
                                    : 'text-[var(--color-secondary)] hover:text-[var(--color-primary)]' }}"
                            @click="open = false"
                        >
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach

            </ul>

        </nav>

        <div class="mobile-social justify-end p-4">

            <h4 class="text-xl mb-2">Follow us:</h4>

            <x-social-media />

        </div>

    </div>

</header>