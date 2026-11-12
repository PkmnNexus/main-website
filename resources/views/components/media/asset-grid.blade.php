@props([
    'assets',
    'selectionEvent' => 'asset-selected',
    'editorInsert' => false,
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
            <x-media.asset-card
                :asset="$asset"
                :selection-event="$selectionEvent"
                :editor-insert="$editorInsert"
            />
        </div>
    @empty
        <p class="col-span-full text-sm text-gray-500">
            {{ __('admin.no_assets_found') }}
        </p>
    @endforelse
</div>