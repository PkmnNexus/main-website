@if($embedUrl)

    <div class="aspect-video w-full overflow-hidden rounded-xl">

        @if($thumbnailUrl())

            <meta itemprop="thumbnailUrl" content="{{ $thumbnailUrl() }}">

        @endif

        <iframe src="{{ $embedUrl }}"
                class="block h-full w-full"
                title="{{ $article->title }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen
                loading="{{ $loading }}"
                itemprop="embedUrl"></iframe>

    </div>

@elseif($article->heroImage)

    <x-pages.responsive-picture
        :article="$article"
        sizes="(min-width: 1024px) 896px, 100vw"
        class="block h-auto w-full rounded-xl object-cover"
        loading="eager"
    />

@endif