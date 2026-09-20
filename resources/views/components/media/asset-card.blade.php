@props([
    'asset',
    'selectable' => true,
])

<button
    type="button"
    @disabled(! $selectable)

    x-on:click="
        selectedAssetId = {{ $asset->id }};
        selectedAsset = assets.find(asset => asset.id === {{ $asset->id }});

        if (selectedAsset) {
            window.dispatchEvent(new CustomEvent('pkmnexus-asset-picked', {
                detail: {
                    id: selectedAsset.id,
                    url: selectedAsset.url,
                    alt: selectedAsset.alt || selectedAsset.title || '',
                }
            }));
        }
    "

    data-asset-id="{{ $asset->id }}"

    class="group relative block w-full overflow-hidden rounded-xl bg-white text-left transition-all duration-300"

    :class="{
        'border-2 border-primary-500 ring-4 ring-primary-500/20 shadow-2xl scale-[1.03]': selectedAssetId == {{ $asset->id }},

        'border border-gray-200 hover:border-primary-400 hover:ring-2 hover:ring-primary-500/10 hover:shadow-xl hover:-translate-y-1': selectedAssetId != {{ $asset->id }},
    }"
>

    <div class="relative aspect-[4/3] overflow-hidden rounded-xl">

        <img
            src="{{ $asset->getFirstMediaUrl('asset', 'thumb') }}"
            alt="{{ $asset->title }}"
            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
        >

        <div
            x-show="selectedAssetId == {{ $asset->id }}"
            x-transition.scale
            class="absolute right-3 top-3 z-20"
        >
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 shadow-lg">
                <x-heroicon-m-check class="h-5 w-5 text-white" />
            </div>
        </div>

        <div
            class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-black via-black/40 to-transparent"
        ></div>

        <div class="absolute inset-x-0 bottom-0 p-3">

            <h3 class="truncate text-sm font-semibold text-white">
                {{ $asset->title }}
            </h3>

            <div class="mt-1 flex items-center gap-2 text-xs text-white/80">

                <span>
                    {{ $asset->width }} × {{ $asset->height }}
                </span>

                <span>•</span>

                <span>
                    {{ number_format($asset->file_size / 1024, 1) }} KB
                </span>

            </div>

        </div>

    </div>

</button>