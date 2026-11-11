<?php

namespace App\Filament\Resources\PokemonTcgSets\Pages;

use App\Filament\Resources\PokemonTcgSets\PokemonTcgSetResource;
use App\Filament\Resources\PokemonTcgSets\Widgets\PokemonTcgSetSyncProgress;
use App\Services\PokemonTcg\PokemonTcgSetSync;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Throwable;

class ListPokemonTcgSets extends ListRecords
{
    protected static string $resource = PokemonTcgSetResource::class;

    public function getTitle(): string
    {
        return __('admin.sets');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PokemonTcgSetSyncProgress::class,
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
                ->label(__('admin.synchronize_sets'))
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading(__('admin.synchronize_sets'))
                ->modalDescription(__('admin.synchronize_sets_confirmation'))
                ->action(function (PokemonTcgSetSync $sync): void {
                    try {
                        $syncRun = $sync->dispatch();

                        $this->dispatch('pokemon-tcg-set-sync-started');

                        Notification::make()
                            ->title(__('admin.set_synchronization_started'))
                            ->body(__('admin.set_synchronization_started_result', [
                                'total' => $syncRun->total,
                            ]))
                            ->success()
                            ->send();
                    } catch (Throwable $exception) {
                        report($exception);

                        Notification::make()
                            ->title(__('admin.set_synchronization_failed'))
                            ->body($exception->getMessage())
                            ->danger()
                            ->persistent()
                            ->send();
                    }
                }),

            CreateAction::make()
                ->label(__('admin.create_set')),
        ];
    }
}