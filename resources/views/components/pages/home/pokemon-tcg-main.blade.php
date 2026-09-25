<article class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition duration-300 mb-6"
         itemscope
         itemtype="https://schema.org/Article">

    <a  href="{{ route('article.show', [
            'category' => $article->category->slug,
            'slug' => $article->slug,
        ]) }}"
        class="block">

        <figure class="relative">

            <x-pages.responsive-picture
                :image="$article->heroImage?->responsiveImage('hero-webp')"
                :alt="$article->title"
                sizes="(min-width: 1280px) 1024px, (min-width: 768px) 768px, 100vw"
                class="w-full h-[300px] md:h-[280px] object-cover group-hover:scale-105 transition duration-300"
                loading="lazy"
                fetchpriority="auto"
                itemprop="image"
            />

            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

            <figcaption class="absolute bottom-0 p-6 text-white z-10">

                <h2 class="text-xl md:text-3xl !text-white">{{ $article->title }}</h2>

            </figcaption>

        </figure>

    </a>

</article>