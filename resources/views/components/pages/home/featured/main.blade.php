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

            <span class="absolute top-0 right-0 m-[15px] px-2 py-1 bg-[var(--color-primary)] text-white text-md font-black font-display uppercase rounded">{{ filled($article->video_url) ? 'Video' : $article->category->name }}</span>

            @if (filled($article->video_url))

                <div class="absolute inset-0 grid place-items-center pointer-events-none z-10">

                    <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-white bg-black/40 text-white -translate-x-[2px] transition duration-300 group-hover:bg-[var(--color-primary)] group-hover:scale-110">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="block w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M8 5.14v13.72a.75.75 0 0 0 1.13.65l11-6.86a.75.75 0 0 0 0-1.3l-11-6.86A.75.75 0 0 0 8 5.14Z"/>
                        </svg>

                    </div>

                </div>
                
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

            <figcaption class="absolute bottom-0 right-10 p-6 text-white z-10">

                <h3 class="text-3xl line-clamp-2 leading-8 !text-white" itemprop="headline">{{ $article->title }}</h3>

                <p class="mt-2 text-xl leading-6 font-light opacity-90" itemprop="description">{{ $article->excerpt }}</p>

            </figcaption>

        </figure>

    </x-pages.links.article-link>

</article>