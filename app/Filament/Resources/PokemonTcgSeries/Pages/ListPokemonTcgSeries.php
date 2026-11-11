<?php

namespace App\Filament\Resources\PokemonTcgSeries\Pages;

use App\Filament\Resources\PokemonTcgSeries\PokemonTcgSeriesResource;
use App\Filament\Resources\PokemonTcgSeries\Widgets\PokemonTcgSeriesSyncProgress;
use App\Services\PokemonTcg\PokemonTcgSeriesSync;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Throwable;

class ListPokemonTcgSeries extends ListRecords
{
    protected static string $resource = PokemonTcgSeriesResource::class;

    public function getTitle(): string
    {
        return __('admin.series');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PokemonTcgSeriesSyncProgress::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('synchronize')
                ->label(__('admin.synchronize_series'))
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading(__('admin.synchronize_series'))
                ->modalDescription(__('admin.synchronize_series_confirmation'))
                ->action(function (PokemonTcgSeriesSync $sync): void {
                    try {
                        $syncRun = $sync->dispatch();

                        $this->dispatch('pokemon-tcg-series-sync-started');

                        Notification::make()
                            ->title(__('admin.series_synchronization_started'))
                            ->body(__('admin.series_synchronization_started_result', [
                                'total' => $syncRun->total,
                            ]))
                            ->success()
                            ->send();
                    } catch (Throwable $exception) {
                        report($exception);

                        Notification::make()
                            ->title(__('admin.series_synchronization_failed'))
                            ->body($exception->getMessage())
                            ->danger()
                            ->persistent()
                            ->send();
                    }
                }),

            CreateAction::make()
                ->label(__('admin.create_series')),
        ];
    }
}