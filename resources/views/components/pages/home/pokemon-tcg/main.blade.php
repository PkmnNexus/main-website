<article class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition duration-300 mb-6"
         itemscope
         itemtype="https://schema.org/Article">

    <x-pages.links.article-link :article="$article" class="block">

        <figure class="relative">

            <x-pages.responsive-picture
                :article="$article"
                sizes="(min-width: 1280px) 1024px, (min-width: 768px) 768px, 100vw"
                class="w-full h-[300px] md:h-[280px] object-cover group-hover:scale-105 transition duration-300"
                loading="eager"
                fetchpriority="auto"
            />

            @if(filled($article->video_url))

                <span class="absolute top-0 right-0 m-[15px] px-2 py-1 bg-[var(--color-primary)] text-white text-md font-black font-display uppercase rounded">__('general.video')</span>
            
            @endif

            <x-play-button :article="$article" />

            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

            <figcaption class="absolute bottom-0 p-6 text-white z-10">

                <h2 class="text-xl md:text-3xl !text-white">{{ $article->title }}</h2>

            </figcaption>

        </figure>

    </x-pages.links.article-link>

</article>