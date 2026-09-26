@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- Mobile --}}
        <div class="flex gap-2 items-center justify-between sm:hidden">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm font-display text-gray-300 bg-[#FAFAFA] rounded-md cursor-not-allowed">
                    ←
                </span>
            @else
                <button
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 text-sm font-display bg-[#FAFAFA] text-gray-400 rounded-md hover:bg-[var(--color-secondary)] hover:text-white transition">
                    ←
                </button>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 text-sm font-display bg-[#FAFAFA] text-gray-400 rounded-md hover:bg-[var(--color-secondary)] hover:text-white transition">
                    →
                </button>
            @else
                <span class="px-4 py-2 text-sm font-display text-gray-300 bg-[#FAFAFA] rounded-md cursor-not-allowed">
                    →
                </span>
            @endif

        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between">

            {{-- Info --}}
            <div>
                <p class="text-sm text-gray-400 font-light">
                    @if ($paginator->firstItem())
                        {{ $paginator->firstItem() }} – {{ $paginator->lastItem() }}
                    @else
                        {{ $paginator->count() }}
                    @endif
                    / {{ $paginator->total() }}
                </p>
            </div>

            {{-- Pages --}}
            <div class="flex gap-2 items-center">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-2 text-gray-300 bg-[#FAFAFA] rounded-md cursor-not-allowed">
                        ←
                    </span>
                @else
                    <button
                        wire:click="previousPage"
                        wire:loading.attr="disabled"
                        class="px-3 py-2 bg-[#FAFAFA] text-gray-400 rounded-md hover:bg-[var(--color-secondary)] hover:text-white transition">
                        ←
                    </button>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)

                    @if (is_string($element))
                        <span class="px-3 py-2 text-gray-300">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)

                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-2 font-display bg-[var(--color-primary)] text-white rounded-md">
                                    {{ $page }}
                                </span>
                            @else
                                <button
                                    wire:click="gotoPage({{ $page }})"
                                    wire:loading.attr="disabled"
                                    class="px-3 py-2 font-display bg-[#FAFAFA] text-gray-400 rounded-md hover:bg-[var(--color-secondary)] hover:text-white transition">
                                    {{ $page }}
                                </button>
                            @endif

                        @endforeach
                    @endif

                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <button
                        wire:click="nextPage"
                        wire:loading.attr="disabled"
                        class="px-3 py-2 bg-[#FAFAFA] text-gray-400 rounded-md hover:bg-[var(--color-secondary)] hover:text-white transition">
                        →
                    </button>
                @else
                    <span class="px-3 py-2 text-gray-300 bg-[#FAFAFA] rounded-md cursor-not-allowed">
                        →
                    </span>
                @endif

            </div>
        </div>
    </nav>
@endif