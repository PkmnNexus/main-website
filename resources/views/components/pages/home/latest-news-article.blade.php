<article {{ $attributes }}
         itemscope
         itemtype="https://schema.org/Article"
         itemprop="itemListElement">

    <meta itemprop="position" content="{{ $position }}">

    <a href="{{ route('article.show', [
            'category' => $article->category->slug,
            'slug' => $article->slug,
        ]) }}"
        class="group"
        itemprop="url">

        {{ $slot }}

    </a>

</article>