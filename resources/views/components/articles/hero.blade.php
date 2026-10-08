<div class="overflow-hidden rounded-xl shadow-lg">

    @if($article->video_url)

        <x-pages.video-embed :article="$article" />

    @else

        <x-pages.responsive-picture
            :article="$article"
            sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
            class="w-full h-full object-cover block rounded-xl shadow-lg transition duration-300 group-hover:scale-105 group-hover:shadow-xl"
            loading="eager"
            fetchpriority="high"
        />

    @endif

</div>