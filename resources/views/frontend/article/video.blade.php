
<x-app :pageSeo="$pageSeo">

    <article class="max-w-5xl mx-auto px-6 xl:px-0 py-12" aria-labelledby="video-heading">

        <x-pages.video-embed :article="$article" loading="eager" />

        <header class="mt-6 rounded-xl bg-white shadow-md p-10">

            <h1 id="video-heading" class="text-3xl font-bold">{{ $article->title }}</h1>

            @php
                $description = $article->meta_description ?: $article->excerpt;
            @endphp

            @if(filled($description))

                <p class="mt-2 font-display text-secondary text-lg font-bold leading-snug tracking-wide md:text-xl">{{ $description }}</p>

            @endif

        </header>

    </article>

</x-app>
