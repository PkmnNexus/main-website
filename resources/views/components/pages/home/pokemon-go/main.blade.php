<article class="group relative mb-6 overflow-hidden rounded-xl shadow-lg transition duration-300 hover:shadow-2xl"
         itemscope
         itemtype="https://schema.org/Article">

    <x-pages.links.article-link :article="$article" class="block">

        <figure class="relative">

            <x-pages.responsive-picture
                :article="$article"
                sizes="(min-width: 1280px) 1024px, (min-width: 768px) 768px, 100vw"
                class="h-[300px] w-full object-cover transition duration-300 group-hover:scale-105 md:h-[350px]"
                loading="eager"
                fetchpriority="auto"
            />

            @if(filled($article->video_url))

                <span class="absolute top-0 right-0 m-[15px] px-2 py-1 bg-[var(--color-primary)] text-white text-md font-black font-display uppercase rounded">__('general.video')</span>
            
            @endif

            <x-play-button :article="$article" />

            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

            <figcaption class="absolute bottom-0 z-10 p-6 text-white">

                <h2 class="text-xl !text-white md:text-3xl">
                    {{ $article->title }}
                </h2>

            </figcaption>

        </figure>

    </x-pages.links.article-link>

</article>
