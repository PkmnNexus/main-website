<article {{ $attributes }}
         itemscope
         itemtype="https://schema.org/Article"
         itemprop="itemListElement">

    <meta itemprop="position" content="{{ $position }}">

    <x-pages.links.article-link :article="$article" class="group">

        {{ $slot }}

    </x-pages.links.article-link>

</article>