@props([
    'folder',
])

<div
    x-data="{ open: true }"
    class="space-y-1"
>
    <div
        class="flex items-center gap-1 rounded-lg px-2 py-1 transition-colors"
        :class="selectedFolderId == {{ $folder->id }}
            ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400'
            : 'hover:bg-primary-50 dark:hover:bg-primary-500/10'"
    >

        {{-- Chevron --}}
        @if ($folder->hasChildren())

            <span
                class="flex h-5 w-5 shrink-0 cursor-pointer items-center justify-center rounded hover:bg-primary-100 dark:hover:bg-primary-500/20"
                @click.stop="open = !open"
            >
                <x-heroicon-m-chevron-right
                    class="h-4 w-4 text-gray-500 transition-transform duration-200"
                    x-bind:class="{ 'rotate-90': open }"
                />
            </span>

        @else

            <span class="h-5 w-5 shrink-0"></span>

        @endif

        {{-- Folder --}}
        <button
            type="button"
            class="flex min-w-0 flex-1 items-center gap-2 rounded-md px-1 py-1 text-left focus:outline-none"
            @click="selectedFolderId = {{ $folder->id }}"
        >
            <x-dynamic-component
                :component="$folder->icon ?: 'heroicon-o-folder'"
                class="h-5 w-5 shrink-0"
                :class="selectedFolderId == {{ $folder->id }}
                    ? 'text-primary-500'
                    : 'text-gray-400'"
            />

            <span class="truncate">
                {{ $folder->name }}
            </span>

            <span
                class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500 dark:bg-gray-800"
            >
                {{ $folder->assets_count }}
            </span>
        </button>

    </div>

    @if ($folder->hasChildren())

        <div
            x-show="open"
            x-transition.opacity.duration.150ms
            class="ml-6 space-y-1 border-l border-gray-200 pl-3 dark:border-gray-700"
        >
            @foreach ($folder->children as $child)

                <x-media.folder-node
                    :folder="$child"
                />

            @endforeach
        </div>

    @endif

</div>