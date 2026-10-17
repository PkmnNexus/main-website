@props([
    'showBorder' => true,
])

@if($tags->isNotEmpty())

    <ul class="flex flex-wrap p-0 m-0 list-none {{ $showBorder ? 'border-t border-gray-200 pt-6' : '' }}"
        itemscope
        itemtype="https://schema.org/ItemList">

        @foreach($tags as $tag)

            <li class="mr-2 mb-2"
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/ListItem">
                
                <a href="{{ route('articles.tag', $slug($tag)) }}" class="px-4 py-2 text-xs font-bold uppercase bg-[#F5F5F5] font-display text-[var(--color-secondary)] transition hover:bg-[var(--color-secondary)] hover:text-white rounded-sm inline-block"
                   itemprop="item"
                   itemscope
                   itemtype="https://schema.org/Thing">
                   
                    <span itemprop="name">{{ $name($tag) }}</span>

                </a>

            </li>

        @endforeach

    </ul>

@endif