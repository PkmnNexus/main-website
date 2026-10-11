<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

    @foreach($articles as $article)

        <article class="group relative overflow-hidden rounded-xl shadow-lg transition duration-300 hover:shadow-2xl"
                 itemscope
                 itemtype="https://schema.org/Article">

            <x-pages.links.article-link :article="$article" class="block">

                <figure class="relative">

                    <x-pages.responsive-picture
                        :article="$article"
                        sizes="(min-width: 768px) 50vw, 100vw"
                        class="h-[280px] w-full object-cover transition duration-300 group-hover:scale-105"
                        loading="eager"
                        fetchpriority="auto"
                    />

                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                    <figcaption class="absolute bottom-0 z-10 p-6 text-white">

                        <h3 class="text-lg !text-white md:text-xl">{{ $article->title }}</h3>

                    </figcaption>

                </figure>

            </x-pages.links.article-link>

        </article>

    @endforeach

</div>
