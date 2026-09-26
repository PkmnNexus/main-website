<article class="md:col-span-2 group h-full"
         itemscope
         itemtype="https://schema.org/Article"
         itemprop="itemListElement">

    <x-pages.links.article-link :article="$article" class="block h-full">

        <figure class="relative overflow-hidden rounded-lg h-full transition-all duration-300 group-hover:shadow-xl">

            <x-pages.responsive-picture
                :article="$article"
                sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                loading="eager"
                fetchpriority="high"
            />

            <span class="absolute top-0 right-0 m-[15px] px-2 py-1 bg-[var(--color-primary)] text-white text-md font-black font-display uppercase rounded">{{ $article->category->name }}</span>

            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

            <figcaption class="absolute bottom-0 right-10 p-6 text-white z-10">

                <h3 class="text-3xl line-clamp-2 leading-8 !text-white" itemprop="headline">{{ $article->title }}</h3>

                <p class="mt-2 text-xl leading-6 font-light opacity-90" itemprop="description">{{ $article->excerpt }}</p>

            </figcaption>

        </figure>

    </x-pages.links.article-link>

</article>