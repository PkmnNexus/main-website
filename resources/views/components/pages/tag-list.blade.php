@if($tags->isNotEmpty())

    <ul class="flex flex-wrap p-0 m-0 list-none">

        @foreach($tags as $tag)

            <li class="mr-2 mb-2">
                
                <a href="{{ route('articles.tag', $slug($tag)) }}" class="px-4 py-2 text-xs font-bold uppercase bg-[#F5F5F5] font-display text-[var(--color-secondary)] transition hover:bg-[var(--color-secondary)] hover:text-white rounded-sm inline-block">
                   
                    {{ $name($tag) }}

                </a>

            </li>

        @endforeach

    </ul>

@endif