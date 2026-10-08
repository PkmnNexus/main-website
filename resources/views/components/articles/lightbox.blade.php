<div id="article-lightbox" class="fixed inset-0 z-50 hidden bg-black/90" aria-hidden="true">

    <button type="button"
            class="absolute right-4 top-4 z-10 text-white"
            data-lightbox-close
            aria-label="Close image">

        &times;

    </button>

    <button type="button"
            class="absolute left-4 top-1/2 z-10 -translate-y-1/2 text-white"
            data-lightbox-prev
            aria-label="Previous image">

        &#8592;

    </button>

    <div class="flex h-full w-full items-center justify-center p-6 md:p-10" data-lightbox-backdrop>

        <img src="" alt="" class="max-h-full max-w-full rounded-xl object-contain shadow-2xl" data-lightbox-image>

    </div>

    <button type="button"
            class="absolute right-4 top-1/2 z-10 -translate-y-1/2 text-white"
            data-lightbox-next
            aria-label="Next image">

        &#8594;

    </button>

    <div class="absolute bottom-4 left-1/2 flex max-w-[calc(100%-2rem)] -translate-x-1/2 gap-2 overflow-x-auto scroll-smooth rounded-xl bg-black/50 p-2 backdrop-blur-sm" data-lightbox-thumbnails></div>

</div>

@push('styles')

    @vite('resources/js/articles/lightbox.js')

@endpush