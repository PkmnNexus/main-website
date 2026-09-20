
@php
    $folders = app(\App\Services\MediaFolderService::class)->tree();

    $assetData = $assets->map(fn ($asset) => [
        'id' => $asset->id,
        'title' => $asset->title,
        'alt' => $asset->alt,
        'caption' => $asset->caption,
        'description' => $asset->description,
        'photographer' => $asset->photographer,
        'copyright' => $asset->copyright,
        'width' => $asset->width,
        'height' => $asset->height,
        'file_size' => $asset->file_size,
        'mime_type' => $asset->mime_type,
        'filename' => $asset->getFirstMedia('asset')?->file_name,
        'extension' => pathinfo($asset->getFirstMedia('asset')?->file_name ?? '', PATHINFO_EXTENSION),
        'url' => $asset->getFirstMediaUrl('asset'),
        'thumb' => $asset->getFirstMediaUrl('asset', 'thumb'),
    ])->values();
@endphp

<x-filament::modal
    id="asset-browser"
    slide-over
    width="8xl"
    heading="Asset Browser"
>
    <div
        class="flex h-full flex-col"
        x-data="{
            search: '',

            selectedAssetId: {{ $selectedAssetId ?? 'null' }},

            selectedFolderId: null,

            selectedAsset: null,

            assets: @js($assetData),

            folders: @js($folders),

            breadcrumb(folderId = this.selectedFolderId) {

                if (folderId === null) {
                    return [{
                        id: null,
                        name: 'Alle assets',
                    }]
                }

                const flat = []

                const walk = (items, parent = null) => {

                    items.forEach(item => {

                        flat.push({
                            id: item.id,
                            name: item.name,
                            parent_id: parent,
                        })

                        if (item.children?.length) {
                            walk(item.children, item.id)
                        }

                    })

                }

                walk(this.folders)

                const crumbs = [{
                    id: null,
                    name: 'Alle assets',
                }]

                let current = flat.find(f => f.id == folderId)

                while (current) {

                    crumbs.splice(1, 0, current)

                    current = flat.find(f => f.id == current.parent_id)

                }

                return crumbs
            },
        }"
        @asset-selected.window="selectedAssetId = $event.detail.id"
        @pkmnexus-asset-picked.window="
            const editor = window.__pkmNexusAssetEditor;
            const position = window.__pkmNexusAssetPosition;
            const asset = $event.detail;

            if (!editor || !position || !asset?.url) {
                console.warn('Asset Browser: editor, cursorpositie of afbeelding ontbreekt.');
                return;
            }

            const inserted = editor
                .chain()
                .focus()
                .insertContentAt(position.from, {
                    type: 'image',
                    attrs: {
                        src: asset.url,
                        alt: asset.alt || '',
                    },
                })
                .run();

            if (inserted) {
                window.dispatchEvent(new CustomEvent('close-modal', {
                    detail: { id: 'asset-browser' },
                }));

                window.__pkmNexusAssetPosition = null;
                window.__pkmNexusAssetEditor = null;
            }
        "
    >

        <div class="border-b border-gray-200 p-6 dark:border-gray-700">

            <x-media.breadcrumbs />

            <div class="mt-4 flex items-center gap-4">

                <div class="flex-1">
                    <x-filament::input.wrapper>
                        <x-filament::input
                            x-model.debounce.300ms="search"
                            type="search"
                            placeholder="Zoek assets..."
                        />
                    </x-filament::input.wrapper>
                </div>

            </div>

        </div>

        <div class="flex flex-1 overflow-hidden">

            <aside
                class="w-72 shrink-0 overflow-y-auto border-r border-gray-200 dark:border-gray-700"
            >

                <x-media.folder-tree
                    :folders="$folders"
                />

            </aside>

            <section
                class="flex-1 overflow-y-auto border-r border-gray-200 p-6 dark:border-gray-700"
            >

                <x-media.asset-grid
                    :assets="$assets"
                />

            </section>

            <aside
                class="w-96 shrink-0 overflow-y-auto"
            >

                <x-media.asset-details />

            </aside>

        </div>

    </div>

</x-filament::modal>