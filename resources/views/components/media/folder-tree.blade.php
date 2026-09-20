@props([
    'folders',
])

<nav
    class="space-y-1 p-3"
    aria-label="Media folders"
>

    {{-- Alle assets --}}
    <button
        type="button"
        class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left transition-colors"
        :class="selectedFolderId === null
            ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400'
            : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
        @click="selectedFolderId = null"
    >
        <x-heroicon-o-photo
            class="h-5 w-5"
            :class="selectedFolderId === null
                ? 'text-primary-500'
                : 'text-gray-400'"
        />

        <span class="flex-1 truncate">
            Alle assets
        </span>
    </button>

    @forelse ($folders as $folder)

        <x-media.folder-node
            :folder="$folder"
        />

    @empty

        <p class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
            No folders found.
        </p>

    @endforelse

</nav>