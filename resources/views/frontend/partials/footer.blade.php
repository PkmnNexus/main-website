<footer 
    class="bg-[var(--color-primary)] text-white"
    role="contentinfo"
    itemscope 
    itemtype="https://schema.org/WPFooter"
>

    <div class="footer-inner flex flex-col md:flex-row max-w-3xl xl:max-w-6xl mx-auto px-6 py-6 md:py-3 2xl:px-0 justify-between w-full">

        {{-- COPYRIGHT --}}
        <div 
            class="flex items-center justify-center md:justify-start w-full md:w-1/2"
            itemscope 
            itemtype="https://schema.org/Organization"
        >

            <p 
                class="text-sm md:text-xs m-0 font-semibold"
                itemprop="name"
            >
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>

        </div>

        {{-- FOOTER NAV --}}
        <nav 
            class="w-full mt-4 md:mt-0 md:w-1/2"
            aria-label="Footer navigation"
            itemscope 
            itemtype="https://schema.org/SiteNavigationElement"
        >

            <ul class="flex justify-center md:justify-end space-x-4 font-semibold">

                @foreach (config('navigation.footer') as $item)
                    <li itemprop="name">
                        <a 
                            href="{{ route($item['route']) }}"
                            class="text-white text-sm md:text-xs"
                            itemprop="url"
                        >
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach

            </ul>

        </nav>

    </div>

</footer>