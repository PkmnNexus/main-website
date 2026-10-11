@if($relatedArticles->isNotEmpty())

    <section aria-labelledby="related-content-heading"
             itemscope
             itemtype="https://schema.org/ItemList">

        <div class="space-y-3">

            <h2 class="font-display !text-2xl font-bold text-[var(--color-primary)]">Related articles</h2>

            @foreach($relatedArticles as $article)

                <article class="group mb-3"
                         itemscope
                         itemtype="https://schema.org/Article"
                         itemprop="itemListElement">

                    <x-pages.links.article-link :article="$article"
                                                class="block">

                        <figure class="relative h-40 overflow-hidden rounded-lg transition-all duration-300 group-hover:shadow-xl">

                            <x-pages.responsive-picture :article="$article"
                                                        sizes="(min-width: 1024px) 300px, 100vw"
                                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                                        loading="lazy"/>

                            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                            <figcaption class="absolute inset-x-0 bottom-0 z-10 p-4 text-white">

                                <h3 class="line-clamp-2 text-lg leading-6 !text-white"
                                    itemprop="headline">

                                    {{ $article->title }}

                                </h3>

                            </figcaption>

                        </figure>

                    </x-pages.links.article-link>

                </article>

            @endforeach

        </div>

    </section>

@endif