<a href="{{ localized_route('articles.category', ['category' => $category->getTranslation('slug', app()->getLocale())]) }}" {{ $attributes }}>

    {{ $slot }}

</a>