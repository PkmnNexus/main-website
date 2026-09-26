<a  href="{{ route('article.show', [
        'category' => $article->category->slug,
        'slug' => $article->slug,
    ]) }}"
    itemprop="url"
    {{ $attributes }}>

    {{ $slot }}
    
</a>