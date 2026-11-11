@php
    $assets = \App\Models\Asset::query()
        ->with('media')
        ->latest()
        ->get();

    $assetsJson = $assets->map(fn ($asset) => [
        'id' => $asset->id,
        'title' => $asset->title,
        'width' => $asset->width,
        'height' => $asset->height,
        'mime_type' => $asset->mime_type,
        'thumb' => $asset->getFirstMediaUrl('asset', 'thumb'),
    ])->values();

    $fieldId = preg_replace('/[^A-Za-z0-9_-]/', '-', $getId());
    $modalId = 'asset-browser-'.$fieldId;
    $selectionEvent = 'asset-selected-'.$fieldId;
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
            state: @entangle($getStatePath()),
            browserOpen: false,
            assets: @js($assetsJson),

            get selectedAsset() {
                return this.assets.find(asset => asset.id == this.state) ?? null
            },
        }"
        x-on:{{ $selectionEvent }}.window="
            state = $event.detail.id;
            $dispatch('close-modal', { id: '{{ $modalId }}' });
        "
    >
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <template x-if="selectedAsset">
                <div class="space-y-6">
                    <img
                        :src="selectedAsset.thumb"
                        :alt="selectedAsset.title"
                        class="w-full max-w-sm rounded-xl border-2 border-primary-500 object-cover shadow-xl ring-4 ring-primary-500/15 transition-all duration-300"
                    >

                    <div>
                        <h3
                            class="text-xl font-bold"
                            x-text="selectedAsset.title"
                        ></h3>

                        <div class="mt-3 space-y-1 text-sm text-gray-500">
                            <p x-text="selectedAsset.width + ' × ' + selectedAsset.height"></p>
                            <p x-text="selectedAsset.mime_type"></p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <x-filament::button
                            type="button"
                            color="primary"
                            icon="heroicon-m-photo"
                            x-on:click="$dispatch('open-modal', { id: '{{ $modalId }}' })"
                        >
                            {{ __('admin.change_image') }}
                        </x-filament::button>

                        <x-filament::button
                            type="button"
                            color="danger"
                            icon="heroicon-m-trash"
                            x-on:click="state = null"
                        >
                            {{ __('admin.remove_image') }}
                        </x-filament::button>
                    </div>
                </div>
            </template>

            <template x-if="! selectedAsset">
                <div class="py-10 text-center">
                    <p class="text-sm text-gray-500">
                        {{ __('admin.no_image_selected') }}
                    </p>

                    <div class="mt-4">
                        <x-filament::button
                            type="button"
                            color="gray"
                            x-on:click="$dispatch('open-modal', { id: '{{ $modalId }}' })"
                        >
                            {{ __('admin.select_image') }}
                        </x-filament::button>
                    </div>
                </div>
            </template>
        </div>

        <template x-if="browserOpen">
            <div class="mt-6">
                <x-media.asset-grid
                    :assets="$assets"
                    :selection-event="$selectionEvent"
                />
            </div>
        </template>
    </div>

    @include(
        'filament.forms.components.browser-modal',
        [
            'assets' => $assets,
            'selectedAssetId' => $getState(),
            'modalId' => $modalId,
            'selectionEvent' => $selectionEvent,
        ]
    )
</x-dynamic-component>