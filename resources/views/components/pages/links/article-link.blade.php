<a  href="{{ route('article.show', [
        'category' => $article->category->slug,
        'slug' => $article->slug,
    ]) }}"
    wire:navigate
    itemprop="url"
    {{ $attributes }}>

    {{ $slot }}
    
</a>