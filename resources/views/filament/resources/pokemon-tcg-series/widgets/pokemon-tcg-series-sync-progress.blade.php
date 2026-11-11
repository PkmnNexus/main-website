@php
    $syncRun = $this->getSyncRun();
    $percentage = $this->getProgressPercentage();
@endphp

<div wire:poll.5s>
    @if ($syncRun)
        <x-filament::section>
            <div class="flex flex-col gap-5">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-gray-950 dark:text-white">
                            {{ __('admin.series_synchronization_progress') }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('admin.series_synchronization_processed', [
                                'processed' => $syncRun->processed,
                                'total' => $syncRun->total,
                            ]) }}
                        </p>
                    </div>

                    @if ($syncRun->status === 'running')
                        <x-filament::badge color="info">
                            {{ __('admin.synchronization_running') }}
                        </x-filament::badge>
                    @elseif ($syncRun->status === 'completed' && $syncRun->failed === 0)
                        <x-filament::badge color="success">
                            {{ __('admin.synchronization_completed') }}
                        </x-filament::badge>
                    @elseif ($syncRun->status === 'completed')
                        <x-filament::badge color="warning">
                            {{ __('admin.synchronization_completed_with_errors') }}
                        </x-filament::badge>
                    @elseif ($syncRun->status === 'failed')
                        <x-filament::badge color="danger">
                            {{ __('admin.synchronization_failed') }}
                        </x-filament::badge>
                    @else
                        <x-filament::badge color="gray">
                            {{ ucfirst($syncRun->status) }}
                        </x-filament::badge>
                    @endif
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">
                            {{ __('admin.synchronization_progress') }}
                        </span>

                        <span class="font-semibold text-gray-950 dark:text-white">
                            {{ $percentage }}%
                        </span>
                    </div>

                    <div
                        role="progressbar"
                        aria-valuenow="{{ $percentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="height: 10px; width: 100%; overflow: hidden; border-radius: 9999px; background-color: #e5e7eb;"
                    >
                        <div
                            style="height: 100%; width: {{ $percentage }}%; border-radius: 9999px; background-color: #2563eb; transition: width 500ms ease;"
                        ></div>
                    </div>
                </div>

                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; width: 100%;">
                    <div style="flex: 1 1 120px; min-width: 0;">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('admin.processed') }}
                        </p>
                        <p class="text-xl font-semibold text-gray-950 dark:text-white">
                            {{ number_format($syncRun->processed) }}
                            <span class="text-sm font-normal text-gray-400">
                                / {{ number_format($syncRun->total) }}
                            </span>
                        </p>
                    </div>

                    <div style="flex: 1 1 120px; min-width: 0;">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('admin.created') }}
                        </p>
                        <p class="text-xl font-semibold text-success-600">
                            {{ number_format($syncRun->created) }}
                        </p>
                    </div>

                    <div style="flex: 1 1 120px; min-width: 0;">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('admin.updated') }}
                        </p>
                        <p class="text-xl font-semibold text-primary-600">
                            {{ number_format($syncRun->updated) }}
                        </p>
                    </div>

                    <div style="flex: 1 1 120px; min-width: 0;">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('admin.skipped') }}
                        </p>
                        <p class="text-xl font-semibold text-gray-600 dark:text-gray-300">
                            {{ number_format($syncRun->skipped) }}
                        </p>
                    </div>

                    <div style="flex: 1 1 120px; min-width: 0;">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('admin.failed') }}
                        </p>
                        <p class="text-xl font-semibold text-danger-600">
                            {{ number_format($syncRun->failed) }}
                        </p>
                    </div>
                </div>

                @if ($syncRun->error_message)
                    <div class="rounded-lg bg-danger-50 p-3 text-sm text-danger-700 dark:bg-danger-400/10 dark:text-danger-400">
                        {{ $syncRun->error_message }}
                    </div>
                @endif

                @if ($syncRun->completed_at)
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ __('admin.synchronization_completed_at') }}
                        {{ $syncRun->completed_at->format('d/m/Y H:i:s') }}
                    </p>
                @endif
            </div>
        </x-filament::section>
    @endif
</div>