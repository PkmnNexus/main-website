<div class="aspect-video w-full h-full"
     itemscope
     itemtype="https://schema.org/VideoObject">

    <meta itemprop="name" content="{{ $article->title }}">
    <meta itemprop="thumbnailUrl" content="{{ $thumbnailUrl() }}">
    <meta itemprop="uploadDate" content="{{ $uploadDate() }}">

    <iframe
        src="{{ $embedUrl }}"
        class="w-full h-full"
        frameborder="0"
        allowfullscreen
        loading="{{ $loading }}"
        itemprop="embedUrl"
        title="{{ $article->title }}"
    ></iframe>

</div>