<article
    class="md:col-span-2 group h-full"
    itemscope
    itemtype="https://schema.org/Article"
    itemprop="itemListElement">

    <a
        href="{{ route('article.show', [
            'category' => $articles->category->slug,
            'slug' => $articles->slug,
        ]) }}"
        class="block h-full"
        itemprop="url">

        <figure class="relative overflow-hidden rounded-lg h-full transition-all duration-300 group-hover:shadow-xl">

            <x-pages.home.featured-picture
                :image="$responsiveImage"
                :alt="$articles->heroImage->alt ?: $articles->title"
                sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                loading="eager"
                fetchpriority="high"
                itemprop="image"
            />

            <span class="absolute top-0 right-0 m-[15px] px-2 py-1 bg-[var(--color-primary)] text-white text-md font-black font-display uppercase rounded">{{ $articles->category->name }}</span>

            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

            <figcaption class="absolute bottom-0 right-10 p-6 text-white z-10">

                <h3 class="text-3xl line-clamp-2 leading-8 !text-white" itemprop="headline">{{ $articles->title }}</h3>

                <p class="mt-2 text-xl leading-6 font-light opacity-90" itemprop="description">{{ $articles->excerpt }}</p>

            </figcaption>

        </figure>

    </a>

</article>