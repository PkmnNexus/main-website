<?php

namespace App\Filament\Resources\PokemonTcgCards\Pages;

use App\Filament\Resources\PokemonTcgCards\PokemonTcgCardResource;
use App\Filament\Resources\PokemonTcgCards\Widgets\PokemonTcgCardSyncProgress;
use App\Services\PokemonTcg\PokemonTcgCardSync;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Throwable;

class ListPokemonTcgCards extends ListRecords
{
    protected static string $resource = PokemonTcgCardResource::class;

    public function getTitle(): string
    {
        return __('admin.cards');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PokemonTcgCardSyncProgress::class,
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
                ->label(__('admin.synchronize_cards'))
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading(__('admin.synchronize_cards'))
                ->modalDescription(__('admin.synchronize_cards_confirmation'))
                ->action(function (PokemonTcgCardSync $sync): void {
                    try {
                        $syncRun = $sync->dispatch();

                        $this->dispatch('pokemon-tcg-card-sync-started');

                        Notification::make()
                            ->title(__('admin.card_synchronization_started'))
                            ->body(__('admin.card_synchronization_started_result', [
                                'total' => $syncRun->total,
                            ]))
                            ->success()
                            ->send();
                    } catch (Throwable $exception) {
                        report($exception);

                        Notification::make()
                            ->title(__('admin.card_synchronization_failed'))
                            ->body($exception->getMessage())
                            ->danger()
                            ->persistent()
                            ->send();
                    }
                }),

            CreateAction::make()
                ->label(__('admin.create_card')),
        ];
    }
}