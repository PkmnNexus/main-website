<div class="h-full">

    {{-- Placeholder --}}
    <div
        x-show="! selectedAsset"
        class="flex h-full items-center justify-center p-6"
    >
        <div class="text-center">

            <x-heroicon-o-photo class="mx-auto mb-4 h-12 w-12 text-gray-300" />

            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                Geen asset geselecteerd
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Selecteer een afbeelding om de details te bekijken.
            </p>

        </div>
    </div>

    {{-- Details --}}
    <div
        x-show="selectedAsset"
        x-cloak
        class="flex h-full flex-col"
    >

        {{-- Sticky action bar --}}
        <div
            class="sticky top-0 z-10 border-b border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900"
        >

            <x-filament::button
                color="primary"
                icon="heroicon-o-check"
                class="w-full"
                x-on:click="
                    $dispatch('asset-selected', {
                        id: selectedAsset.id
                    });

                    $dispatch('close-modal', {
                        id: 'asset-browser'
                    });
                "
            >
                Gebruik afbeelding
            </x-filament::button>

        </div>

        {{-- Scrollable content --}}
        <div class="flex-1 overflow-y-auto">

            {{-- Preview --}}
            <div class="border-b border-gray-200 p-6 dark:border-gray-700">

                <div class="overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800">

                    <img
                        :src="selectedAsset?.url"
                        :alt="selectedAsset?.title"
                        class="aspect-[4/3] w-full object-cover"
                    >

                </div>

            </div>

            <div class="space-y-8 p-6">

                {{-- Algemene informatie --}}
                <section>

                    <h3 class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Algemene informatie
                    </h3>

                    <dl class="space-y-4">

                        <div>
                            <dt class="text-xs text-gray-500">Titel</dt>

                            <dd
                                class="font-medium text-gray-900 dark:text-white"
                                x-text="selectedAsset?.title || '-'"
                            ></dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Alt-tekst</dt>

                            <dd
                                class="text-sm"
                                x-text="selectedAsset?.alt || '—'"
                            ></dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Beschrijving</dt>

                            <dd
                                class="whitespace-pre-line text-sm"
                                x-text="selectedAsset?.description || '—'"
                            ></dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Caption</dt>

                            <dd
                                class="text-sm"
                                x-text="selectedAsset?.caption || '—'"
                            ></dd>
                        </div>

                    </dl>

                </section>

                {{-- Bestand --}}
                <section>

                    <h3 class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Bestand
                    </h3>

                    <dl class="space-y-4">

                        <div class="flex justify-between gap-4">

                            <dt class="text-xs text-gray-500">
                                Afmetingen
                            </dt>

                            <dd
                                class="text-sm font-medium"
                                x-text="selectedAsset ? `${selectedAsset.width} × ${selectedAsset.height}` : '—'"
                            ></dd>

                        </div>

                        <div class="flex justify-between gap-4">

                            <dt class="text-xs text-gray-500">
                                Grootte
                            </dt>

                            <dd
                                class="text-sm font-medium"
                                x-text="selectedAsset ? `${(selectedAsset.file_size / 1024).toFixed(1)} KB` : '—'"
                            ></dd>

                        </div>

                        <div class="flex justify-between gap-4">

                            <dt class="text-xs text-gray-500">
                                Bestandstype
                            </dt>

                            <dd
                                class="text-sm font-medium uppercase"
                                x-text="selectedAsset?.extension || '—'"
                            ></dd>

                        </div>

                        <div>

                            <dt class="text-xs text-gray-500">
                                Bestandsnaam
                            </dt>

                            <dd
                                class="break-all text-sm"
                                x-text="selectedAsset?.filename || '—'"
                            ></dd>

                        </div>

                    </dl>

                </section>

                {{-- Credits --}}
                <section>

                    <h3 class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Credits
                    </h3>

                    <dl class="space-y-4">

                        <div>

                            <dt class="text-xs text-gray-500">
                                Fotograaf
                            </dt>

                            <dd
                                class="text-sm"
                                x-text="selectedAsset?.photographer || '—'"
                            ></dd>

                        </div>

                        <div>

                            <dt class="text-xs text-gray-500">
                                Copyright
                            </dt>

                            <dd
                                class="text-sm"
                                x-text="selectedAsset?.copyright || '—'"
                            ></dd>

                        </div>

                    </dl>

                </section>

            </div>

        </div>

    </div>

</div>