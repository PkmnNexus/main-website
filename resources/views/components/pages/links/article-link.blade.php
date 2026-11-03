<a href="{{ filled($article->video_url)
        ? localized_route('article.video', ['slug' => $article->slug])
        : localized_route('article.show', [
            'category' => $article->category->slug,
            'slug' => $article->slug,
        ]) }}"
   itemprop="url"
   {{ $attributes }}>

    {{ $slot }}

</a>