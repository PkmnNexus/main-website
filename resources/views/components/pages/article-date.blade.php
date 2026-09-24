<time class="text-sm font-bold text-[var(--color-primary)] mb-2"
      itemprop="datePublished"
      datetime="{{ $date?->toAtomString() }}">

    {{ $date?->format('F jS Y') }}

</time>