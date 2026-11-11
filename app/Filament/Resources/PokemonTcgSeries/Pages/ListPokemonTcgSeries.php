<?php

namespace App\Filament\Resources\PokemonTcgSeries\Pages;

use App\Filament\Resources\PokemonTcgSeries\PokemonTcgSeriesResource;
use App\Services\PokemonTcg\PokemonTcgSeriesSync;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPokemonTcgSeries extends ListRecords
{
    protected static string $resource = PokemonTcgSeriesResource::class;

    public function getTitle(): string
    {
        return __('admin.series');
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
                    $result = $sync->sync();

                    Notification::make()
                        ->title(__('admin.series_synchronization_completed'))
                        ->body(__('admin.series_synchronization_result', [
                            'total' => $result['total'],
                            'created' => $result['created'],
                            'updated' => $result['updated'],
                            'skipped' => $result['skipped'],
                        ]))
                        ->success()
                        ->send();

                    $this->resetTable();
                }),

            CreateAction::make()
                ->label(__('admin.create_series')),
        ];
    }
}