<div 
    class="bg-[var(--color-secondary)] text-white"
    aria-label="Additional information"
    itemscope 
    itemtype="https://schema.org/WPFooter"
>

    <div class="sub-footer-inner flex flex-col max-w-lg md:max-w-5xl xl:max-w-6xl mx-auto px-6 py-6 md:py-8 2xl:px-0 justify-between w-full">

        <div class="flex flex-col flex-wrap md:flex-row">

            {{-- SITE NAV --}}
            <div 
                class="sub-footer-main-navigation flex flex-col w-full md:w-1/2 lg:w-1/4"
                itemscope 
                itemtype="https://schema.org/SiteNavigationElement"
            >

                <h3 class="text-2xl mb-1 md:mb-3">Site Navigation</h3>

                <ul class="mb-5 lg:mb-0">

                    @foreach (config('navigation.main') as $item)
                        <li itemprop="name">
                            <a 
                                href="{{ route($item['route']) }}"
                                itemprop="url"
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach

                </ul>

            </div>

            {{-- CATEGORIES --}}
            <div 
                class="sub-footer-categories-navigation flex flex-col w-full md:w-1/2 lg:w-1/4"
                itemscope 
                itemtype="https://schema.org/SiteNavigationElement"
            >

                <h3 class="text-2xl mb-3">Pokémon</h3>

                <ul class="mb-5 lg:mb-0">

                    @foreach (config('navigation.categories') as $item)
                        <li itemprop="name">
                            <a 
                                href="{{ route($item['route']) }}"
                                itemprop="url"
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach

                </ul>

            </div>

            {{-- ABOUT --}}
            <div 
                class="sub-footer-about-navigation flex flex-col w-full md:w-1/2 lg:w-1/4"
                itemscope 
                itemtype="https://schema.org/Organization"
            >

                <h3 class="text-2xl mb-3" itemprop="name">
                    {{ config('app.name') }}
                </h3>

                <ul class="mb-5 md:mb-0">

                    @foreach (config('navigation.subfooter') as $item)
                        <li>
                            <a 
                                href="{{ route($item['route']) }}"
                                itemprop="url"
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach

                </ul>

            </div>

            {{-- SOCIAL --}}
            <div 
                class="sub-footer-social-navigation mobile-social-top flex flex-col w-full md:w-1/2 lg:w-1/4"
            >

                <h3 class="text-2xl mb-3">Social Media</h3>

                <div itemprop="sameAs">
                    <x-social-media size="icon-lg" />
                </div>

            </div>

        </div>

        {{-- DISCLAIMER --}}
        <div 
            class="flex flex-col text-center leading-5 text-xs md:text-sm mt-8 mb-0 border-t border-[var(--color-primary)] pt-6"
            itemscope 
            itemtype="https://schema.org/CreativeWork"
        >

            <p class="mb-3 md:mb-1" itemprop="text">
                Pokémon and all related trademarks are © 1995-2025 Nintendo, Creatures, and GAME FREAK. English card images on this website are the property of The Pokémon Company International, Inc.
            </p>

            <p itemprop="text">
                PkmnInsider is an independent fan site. We are not official in any way, nor affiliated, sponsored, or endorsed by Nintendo, Creatures, GAME FREAK, or TPCi.
            </p>

        </div>

    </div>

</div>