<a href="{{ filled($article->video_url)
        ? route('article.video', ['slug' => $article->slug])
        : route('article.show', [
            'category' => $article->category->slug,
            'slug' => $article->slug,
        ]) }}"
   wire:navigate
   itemprop="url"
   {{ $attributes }}>

    {{ $slot }}

</a>