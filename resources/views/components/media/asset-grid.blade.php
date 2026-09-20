@props([
    'assets',
])

<div class="grid grid-cols-3 gap-5 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">

    @forelse ($assets as $asset)

        <div
            class="cursor-pointer"
            data-asset-id="{{ $asset->id }}"
            x-show="
                (
                    selectedFolderId === null ||
                    selectedFolderId == {{ $asset->folder->id }}
                )
                &&
                (
                    search === '' ||

                    '{{ strtolower($asset->title) }}'.includes(search.toLowerCase()) ||

                    '{{ strtolower($asset->alt ?? '') }}'.includes(search.toLowerCase()) ||

                    '{{ strtolower($asset->caption ?? '') }}'.includes(search.toLowerCase()) ||

                    '{{ strtolower($asset->description ?? '') }}'.includes(search.toLowerCase()) ||

                    '{{ strtolower($asset->photographer ?? '') }}'.includes(search.toLowerCase()) ||

                    '{{ strtolower($asset->copyright ?? '') }}'.includes(search.toLowerCase())
                )
            "
        >

            <div
                x-transition:enter="transition-opacity duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <x-media.asset-card :asset="$asset" />
            </div>

        </div>

    @empty

        <div class="col-span-full py-16 text-center text-gray-500">
            No assets found.
        </div>

    @endforelse

</div>