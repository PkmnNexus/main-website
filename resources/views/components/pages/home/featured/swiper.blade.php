<div class="block lg:hidden">

    <div class="swiper relative px-4">

        <div class="swiper-wrapper">

            @foreach($articles->take(5) as $article)

                <div class="swiper-slide" wire:key="featured-mobile-{{ $article->id }}">

                    <article class="group"
                             itemscope
                             itemtype="https://schema.org/Article"
                             itemprop="itemListElement">
                        
                        <x-pages.links.article-link :article="$article">

                            <figure class="relative overflow-hidden rounded-lg">

                                <x-pages.responsive-picture
                                    :article="$article"
                                    sizes="100vw"
                                    class="w-full h-80 md:h-100 object-cover group-hover:scale-105 transition duration-300"
                                    :loading="$loop->first ? 'eager' : 'lazy'"
                                    :fetchpriority="$loop->first ? 'high' : 'auto'"
                                />

                                <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 to-transparent"></div>

                                <figcaption class="absolute bottom-4 p-4 text-white">

                                    <h3 class="text-2xl !text-white" itemprop="headline">{{ $article->title }}</h3>

                                </figcaption>

                            </figure>

                        </x-pages.links.article-link>

                    </article>

                </div>

            @endforeach

        </div>

        <div class="swiper-pagination !bottom-2"></div>

    </div>

</div>