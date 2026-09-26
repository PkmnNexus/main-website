<time {{ $attributes->class([
      ]) }}
     itemprop="datePublished"
     datetime="{{ $date?->toAtomString() }}">

    {{ $date?->format('F jS Y') }}
    
</time>