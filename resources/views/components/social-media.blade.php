@props([
    'size' => 'icon-md'
])

<ul class="flex space-x-2" aria-label="Social media links">

    @foreach (config('socialmedia') as $item)
        <li>

            <a 
                href="{{ $item['url'] }}" 
                target="_blank"
                rel="noopener noreferrer"
                itemprop="sameAs"
                aria-label="{{ $item['label'] ?? 'Social link' }}"
            >                            

                <div class="{{ $size }}">
                    <x-dynamic-component 
                        :component="'icon.' . $item['icon']"
                        aria-hidden="true"
                    />
                </div>

            </a>

        </li>
    @endforeach

</ul>