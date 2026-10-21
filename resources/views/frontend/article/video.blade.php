<x-app :pageSeo="$pageSeo">

    <article class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-7xl mx-auto px-6 xl:px-0 mt-12" aria-labelledby="video-heading" itemscope itemtype="https://schema.org/VideoObject">

        <x-pages.video-embed :article="$article" loading="eager" />

        <meta itemprop="name" content="{{ $article->title }}">
        <meta itemprop="thumbnailUrl" content="{{ $article->youtube_thumbnail_url }}">

        @if($article->youtube_published_at)

            <meta itemprop="uploadDate" content="{{ $article->youtube_published_at->toIso8601String() }}">

        @endif

        @if(filled($article->youtube_duration))

            <meta itemprop="duration" content="{{ $article->youtube_duration }}">

        @endif

        @if(filled($description))

            <meta itemprop="description" content="{{ $description }}">

        @endif

        <x-articles.breadcrumb :article="$article" />

        <div class="grid grid-cols-1 xl:grid-cols-4 xl:gap-8 mt-8">

            <section class="lg:col-span-3 rounded-xl bg-white shadow-md p-10 mb-8 xl:mb-0">

                <header>

                    <h1 id="video-heading" class="text-3xl font-bold" itemprop="headline">{{ $article->title }}</h1>

                    @if(filled($description))

                        <p class="mt-2 font-display text-secondary text-lg font-bold leading-snug tracking-wide md:text-xl" itemprop="description">{{ $description }}</p>

                    @endif

                </header>

                @if(filled($article->content))

                    <div itemprop="articleBody" id="articleBody" class="prose prose-lg max-w-none mt-4">{!! $article->content !!}</div>

                @endif

                <div class="flex flex-wrap items-center justify-between gap-4 mt-4 border-t border-gray-200">

                    <x-articles.tag-cloud :article="$article" :showHeading="false" />
                    <x-articles.social-sharing :article="$article" :showBorder="false" />

                </div>

            </section>

            <aside class="xl:col-span-1">

                <x-articles.video-information :article="$article" :duration="$duration" />

            </aside>

        </div>

    </article>

    <div class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-7xl mx-auto px-6 xl:px-0 pb-12">

        <x-articles.latest-videos :article="$article" />

    </div>

</x-app>