<a href="{{ filled($article->video_url)
        ? route('article.video', ['slug' => $article->slug])
        : route('article.show', [
            'category' => $article->category->getTranslation('slug', app()->getLocale()),
            'slug' => $article->slug,
        ]) }}"
   itemprop="url"
   {{ $attributes }}>

    {{ $slot }}

</a>