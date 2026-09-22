<div class="block lg:hidden">

    <div class="swiper relative px-4">

        <div class="swiper-wrapper">

            @foreach($articles->take(5) as $article)

                @php
                    $responsiveImage = $article->heroImage?->responsiveImage();
                    $isPriority = $loop->first;
                @endphp

                <div class="swiper-slide" wire:key="featured-mobile-{{ $article->id }}">

                    <article
                        class="group"
                        itemscope
                        itemtype="https://schema.org/Article"
                        itemprop="itemListElement">

                        <a href="{{ route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}" itemprop="url">

                            <figure class="relative overflow-hidden rounded-lg">

                                @if($article)

                                    <picture>

                                        @if($responsiveImage->srcset())

                                            <source type="image/webp" srcset="{{ $responsiveImage->srcset() }}" sizes="100vw">

                                        @endif

                                        <img
                                            src="{{ $responsiveImage->src() }}"
                                            alt="{{ $article->heroImage->alt ?: $article->title }}"
                                            width="1600"
                                            height="900"
                                            class="w-full h-80 md:h-100 object-cover group-hover:scale-105 transition duration-300"
                                            loading="{{ $isPriority ? 'eager' : 'lazy' }}"
                                            fetchpriority="{{ $isPriority ? 'high' : 'auto' }}"
                                            decoding="async"
                                            itemprop="image">
                                            
                                    </picture>

                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 to-transparent"></div>

                                <figcaption class="absolute bottom-4 p-4 text-white">

                                    <h3 class="text-2xl !text-white" itemprop="headline">{{ $article->title }}</h3>

                                </figcaption>

                            </figure>

                        </a>

                    </article>

                </div>

            @endforeach

        </div>

        <div class="swiper-pagination !bottom-2"></div>

    </div>

</div>