<picture>

    @if($image->srcset())

        <source
            type="image/webp"
            srcset="{{ $image->srcset() }}"
            sizes="{{ $sizes }}">

    @endif

    <img
        src="{{ $image->src() }}"
        alt="{{ $alt }}"
        width="1600"
        height="900"
        class="{{ $class }}"
        loading="{{ $loading }}"
        fetchpriority="{{ $fetchpriority }}"
        decoding="async"
        @if($itemprop) itemprop="{{ $itemprop }}" @endif>

</picture>