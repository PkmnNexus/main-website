<picture>

    @if($image->srcset())

        <source type="image/webp"
                srcset="{{ $image->srcset() }}"
                sizes="{{ $sizes }}">

    @endif

    <img src="{{ $image->src() }}"
         alt="{{ $alt }}"
         class="{{ $class }}"
         loading="{{ $loading }}"
         fetchpriority="{{ $fetchpriority }}"
         decoding="async"
         itemprop="image"
         width="1600"
         height="900">

</picture>