@if($videos->isNotEmpty())

    <section aria-labelledby="latest-videos-heading" itemscope itemtype="https://schema.org/ItemList">

        <x-pages.section-heading title="More Videos" id="latest-videos-heading" />

        <meta itemprop="name" content="More Videos">
        <meta itemprop="numberOfItems" content="{{ $videos->count() }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($videos as $video)

                <article wire:key="latest-video-{{ $video->id }}" class="group h-full shadow-lg rounded-lg bg-white transition duration-300 hover:shadow-2xl" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">

                    <meta itemprop="position" content="{{ $loop->iteration }}">

                    <x-pages.links.article-link :article="$video" class="block h-full" itemprop="item" itemscope itemtype="https://schema.org/VideoObject">

                        <figure class="relative overflow-hidden rounded-t-lg">

                            @if(filled($video->youtube_thumbnail_url))

                                <img src="{{ $video->youtube_thumbnail_url }}" alt="{{ $video->title }}" class="block w-full aspect-video object-cover transition duration-300 group-hover:scale-105" loading="lazy" itemprop="thumbnailUrl">

                            @else

                                <x-pages.responsive-picture
                                    :article="$video"
                                    sizes="(min-width: 1024px) 25vw, (min-width: 640px) 50vw, 100vw"
                                    class="block w-full aspect-video object-cover transition duration-300 group-hover:scale-105"
                                    loading="lazy"
                                    fetchpriority="auto"
                                />

                            @endif

                            @if($video->youtube_published_at)

                                <div class="absolute top-3 left-3 z-10 px-3 py-2 text-xs uppercase font-display font-black text-white rounded-sm bg-[var(--color-primary)]">

                                    <time datetime="{{ $video->youtube_published_at->toIso8601String() }}" itemprop="uploadDate">{{ $video->youtube_published_at->translatedFormat('F jS Y') }}</time>

                                </div>

                            @endif

                            <x-play-button :article="$video" width="w-10" height="h-10" svg-width="w-4" svg-height="h-4" />

                            @if(filled($video->youtube_duration))

                                @php
                                    $duration = \Carbon\CarbonInterval::create($video->youtube_duration)->cascade()->format('%H:%I:%S');
                                    $duration = ltrim($duration, '0:');
                                @endphp

                                <span class="absolute bottom-2 right-2 z-20 rounded bg-black/75 px-2 py-1 text-xs font-bold text-white" itemprop="duration" content="{{ $video->youtube_duration }}">{{ $duration }}</span>

                            @endif

                        </figure>

                        <div class="p-5">

                            <h3 class="text-lg font-bold leading-snug line-clamp-2 transition-colors group-hover:text-[var(--color-primary)]" itemprop="name">{{ $video->title }}</h3>

                            <p itemprop="description" id="articleBody" class="prose prose-lg max-w-none mt-4">{{ $article->excerpt }}</p>

                        </div>

                    </x-pages.links.article-link>

                </article>

            @endforeach

        </div>

    </section>

@endif