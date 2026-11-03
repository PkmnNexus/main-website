<time {{ $attributes->class([
      ]) }}
     itemprop="datePublished"
     datetime="{{ $date?->toAtomString() }}">

    {{ localized_date($date, showTime: false) }}
    
</time>