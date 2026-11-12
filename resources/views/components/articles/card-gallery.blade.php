@if ($cards->isNotEmpty())

    <section x-data="{ search: '' }"
             class="mt-8"
             aria-label="Pokémon TCG card gallery">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">

            <h2 class="font-display text-primary font-black text-2xl md:text-3xl">Card Gallery: {{ $cards->pluck('set')->filter()->unique('id')->pluck('display_name')->join(', ') }}</h2>

            <div class="w-full md:max-w-xs relative">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-secondary pointer-events-none">
                    <circle cx="11" cy="11" r="8" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35" />
                </svg>

                <input type="search"
                       x-model.debounce.200ms="search"
                       placeholder="Search cards..."
                       aria-label="Search Pokémon TCG cards"
                       class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-sm shadow-sm transition focus:border-primary focus:ring-2 focus:ring-primary/20">

            </div>

        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">

            @foreach ($cards as $card)

                <button type="button"
                        data-lightbox-group="pokemon-tcg-cards"
                        data-lightbox-item
                        data-lightbox-src="{{ $card->display_image_url }}"
                        data-lightbox-thumb="{{ $card->display_thumbnail_url }}"
                        x-show="!search || {{ Illuminate\Support\Js::from(Str::lower(implode(' ', array_filter([
                            $card->display_name,
                            $card->api_name,
                            $card->api_local_id,
                            $card->api_rarity,
                            $card->set?->display_name,
                        ])))) }}.includes(search.toLowerCase())"
                        class="group w-full cursor-pointer rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-primary/15 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">

                    <div class="overflow-hidden rounded-lg">

                        <img src="{{ $card->display_thumbnail_url }}"
                             alt="{{ $card->display_name }}"
                             loading="lazy"
                             class="w-full h-auto transition-all duration-300">

                    </div>

                </button>

            @endforeach

        </div>

        <p x-show="search && !$el.previousElementSibling.querySelector('button:not([style*=display])')"
           x-cloak
           class="text-secondary text-center py-8">
            No cards found.
        </p>

    </section>

@endif
