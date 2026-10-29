<footer class="bg-gradient text-white"
        role="contentinfo"
        itemscope 
        itemtype="https://schema.org/WPFooter">

    <div class="footer-inner flex flex-col md:flex-row max-w-xl md:max-w-6xl xl:max-w-7xl mx-auto px-6 py-6 md:py-3 2xl:px-0 justify-between w-full">

        <div class="flex items-center justify-center md:justify-start w-full md:w-1/2"
             itemscope 
             itemtype="https://schema.org/Organization">

            <p class="text-sm md:text-xs m-0 font-semibold" itemprop="name">&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('general.all_rights_reserved') }}</p>

        </div>

        <nav class="w-full mt-4 md:mt-0 md:w-1/2"
             aria-label="Footer navigation"
             itemscope 
             itemtype="https://schema.org/SiteNavigationElement">

            <ul class="flex justify-center md:justify-end space-x-4 font-semibold">

                @foreach (config('navigation.footer') as $item)

                    <li itemprop="name">

                        <a href="{{ app(\App\Support\NavigationUrl::class)->for($item) }}"
                           class="text-white text-sm md:text-xs"
                           itemprop="url">

                            {{ __($item['label']) }}
                            
                        </a>

                    </li>

                @endforeach

            </ul>

        </nav>

    </div>

</footer>