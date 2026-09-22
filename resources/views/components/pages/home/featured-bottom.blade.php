<div class="hidden px-6 xl:px-0 lg:grid grid-cols-4 gap-4 mt-4">

    @foreach($articles as $article)

        <article
            class="group"
            wire:key="featured-bottom-{{ $article->id }}"
            itemscope
            itemtype="https://schema.org/Article"
            itemprop="itemListElement">

            <a
                href="{{ route('article.show', [
                    'category' => $article->category->slug,
                    'slug' => $article->slug,
                ]) }}"
                itemprop="url">

                <figure class="relative overflow-hidden rounded-lg transition-all duration-300 group-hover:shadow-xl">

                    <x-pages.home.featured-picture
                        :image="$article->heroImage?->responsiveImage()"
                        :alt="$article->heroImage->alt ?: $article->title"
                        sizes="(min-width: 1024px) 25vw, 50vw"
                        class="w-full h-40 object-cover group-hover:scale-105 transition duration-300"
                        loading="lazy"
                        fetchpriority="auto"
                        decoding="async"
                        itemprop="image"
                    />

                    <span class="absolute top-0 right-0 m-[15px] px-2 py-1 bg-[var(--color-primary)] text-white text-xs font-black font-display uppercase rounded">{{ $article->category->name }}</span>

                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                    <figcaption class="absolute bottom-0 p-3 !text-white z-10">

                        <h4 class="!text-white" itemprop="headline">{{ $article->title }}</h4>

                    </figcaption>

                </figure>

            </a>

        </article>

    @endforeach

</div>