@props([
    'article',
    'width' => 'w-14',
    'height' => 'h-14',
    'svgWidth' => 'w-6',
    'svgHeight' => 'h-6',
])

@if (filled($article->video_url))

    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">

        <div class="flex items-center justify-center {{ $width }} {{ $height }} rounded-full border-2 border-white bg-black/40 text-white transition duration-300 group-hover:bg-[var(--color-primary)] group-hover:scale-110">

            <svg xmlns="http://www.w3.org/2000/svg" class="block {{ $svgWidth }} {{ $svgHeight }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M8 5.14v13.72a.75.75 0 0 0 1.13.65l11-6.86a.75.75 0 0 0 0-1.3l-11-6.86A.75.75 0 0 0 8 5.14Z"/>
            </svg>

        </div>

    </div>

@endif