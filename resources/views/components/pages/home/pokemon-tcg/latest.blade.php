<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @foreach($articles as $article)

        <article class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition duration-300"
                 itemscope
                 itemtype="https://schema.org/Article">

            <x-pages.links.article-link :article="$article" class="block">

                <figure class="relative">

                    <x-pages.responsive-picture
                        :article="$article"
                        sizes="(min-width: 768px) 50vw, 100vw"
                        class="w-full h-[360px] object-cover group-hover:scale-105 transition duration-300"
                        loading="eager"
                        fetchpriority="auto"
                    />

                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                    <figcaption class="absolute bottom-0 p-6 text-white z-10">

                        <h3 class="text-lg md:text-xl !text-white">{{ $article->title }}</h3>

                        <p class="text-xl md:text-default font-light mt-2 opacity-90">{{ $article->excerpt }}</p>

                    </figcaption>

                </figure>

            </x-pages.links.article-link>

        </article>

    @endforeach

</div>