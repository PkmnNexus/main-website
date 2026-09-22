<div class="grid grid-rows-2 gap-4 h-full">

    @foreach($articles as $article)

        <article
            class="group h-full"
            wire:key="featured-top-{{ $article->id }}"
            itemscope
            itemtype="https://schema.org/Article"
            itemprop="itemListElement">

            <a
                href="{{ route('article.show', [
                    'category' => $article->category->slug,
                    'slug' => $article->slug,
                ]) }}"
                class="block h-full"
                itemprop="url">

                <figure class="relative overflow-hidden rounded-lg h-full transition-all duration-300 group-hover:shadow-xl">

                    <x-pages.home.featured-picture
                        :image="$article->heroImage?->responsiveImage()"
                        :alt="$article->heroImage->alt ?: $article->title"
                        sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                        loading="lazy"
                        fetchpriority="auto"
                        decoding="async"
                        itemprop="image"
                    />

                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                    <figcaption class="absolute bottom-0 p-4 text-white z-10">

                        <h4 class="text-xl line-clamp-2 !text-white" itemprop="headline" >{{ $article->title }}</h4>

                    </figcaption>

                </figure>

            </a>

        </article>

    @endforeach

</div>