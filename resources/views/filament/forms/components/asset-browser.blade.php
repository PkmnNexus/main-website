<div class="space-y-6">

    <x-media.asset-grid
        :assets="$assets"
        :selectedAssetId="$getState()"
        :statePath="$field->getStatePath()"
    />

</div>