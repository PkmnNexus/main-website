<div wire:poll.5s>
    @php
        $syncRun = $this->getSyncRun();
        $percentage = $this->getProgressPercentage();
    @endphp

    @if ($syncRun)
        <x-filament-widgets::widget>
            <x-filament::section>
                <x-slot name="heading">
                    {{ __('admin.card_synchronization_progress') }}
                </x-slot>

                <div class="space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <div class="text-sm font-medium">
                                {{ __('admin.card_synchronization_processed', [
                                    'processed' => number_format($syncRun->processed),
                                    'total' => number_format($syncRun->total),
                                ]) }}
                            </div>
                        </div>

                        <x-filament::badge
                            :color="match ($syncRun->status) {
                                'completed' => 'success',
                                'failed' => 'danger',
                                default => 'info',
                            }"
                        >
                            {{ __('admin.synchronization_'.$syncRun->status) }}
                        </x-filament::badge>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ __('admin.synchronization_progress') }}
                        </span>

                        <span class="font-semibold tabular-nums">
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

                    <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; width: 100%;">
                        <div style="flex: 1 1 120px; min-width: 0;">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.processed') }}
                            </p>
                            <p class="text-lg font-semibold tabular-nums">
                                {{ number_format($syncRun->processed) }}
                                <span class="text-sm font-normal text-gray-400">
                                    / {{ number_format($syncRun->total) }}
                                </span>
                            </p>
                        </div>

                        <div style="flex: 1 1 120px; min-width: 0;">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.created') }}
                            </p>
                            <p class="text-lg font-semibold tabular-nums text-success-600">
                                {{ number_format($syncRun->created) }}
                            </p>
                        </div>

                        <div style="flex: 1 1 120px; min-width: 0;">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.updated') }}
                            </p>
                            <p class="text-lg font-semibold tabular-nums text-primary-600">
                                {{ number_format($syncRun->updated) }}
                            </p>
                        </div>

                        <div style="flex: 1 1 120px; min-width: 0;">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.skipped') }}
                            </p>
                            <p class="text-lg font-semibold tabular-nums text-gray-600 dark:text-gray-300">
                                {{ number_format($syncRun->skipped) }}
                            </p>
                        </div>

                        <div style="flex: 1 1 120px; min-width: 0;">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.failed') }}
                            </p>
                            <p class="text-lg font-semibold tabular-nums text-danger-600">
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
                        <div class="border-t border-gray-200 pt-3 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                            {{ __('admin.synchronization_completed_at') }}:
                            {{ $syncRun->completed_at->format('d/m/Y H:i:s') }}
                        </div>
                    @endif
                </div>
            </x-filament::section>
        </x-filament-widgets::widget>
    @endif
</div>