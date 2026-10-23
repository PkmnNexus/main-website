@props(['links'])

@if (count($links))

    <div class="space-y-4">

        @foreach ($links as $link)

            <div class="icon-sm">

                <a href="{{ $link['url'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="{{ $link['platform'] }} profile"
                   title="{{ $link['platform'] }}"
                   class="inline-flex items-center gap-2 text-[var(--color-secondary)] hover:text-[var(--color-primary)] break-words">

                    <x-dynamic-component
                        :component="$link['icon']"
                        size="24"
                    />

                    <span>{{ $link['platform'] }}</span>

                </a>
            
            </div>

        @endforeach

    </div>

@else

    <p class="text-sm text-gray-500">There are no social media links.</p>

@endif