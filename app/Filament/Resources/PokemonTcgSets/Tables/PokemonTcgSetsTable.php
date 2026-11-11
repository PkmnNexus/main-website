<?php

namespace App\Filament\Resources\PokemonTcgSets\Tables;

use App\Models\PokemonTcgSet;
use App\Services\PokemonTcg\PokemonTcgCardSync;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Throwable;

class PokemonTcgSetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('display_logo_url')
                    ->label(__('admin.logo'))
                    ->height(25)
                    ->width(50)
                    ->state(fn (PokemonTcgSet $record): ?string => $record->display_logo_url),

                ImageColumn::make('display_symbol_url')
                    ->label(__('admin.symbol'))
                    ->height(20)
                    ->width(20)
                    ->state(fn (PokemonTcgSet $record): ?string => $record->display_symbol_url),

                TextColumn::make('display_name')
                    ->label(__('admin.name'))
                    ->searchable(['name', 'api_name'])
                    ->sortable(),

                TextColumn::make('series.display_name')
                    ->label(__('admin.series'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('external_id')
                    ->label(__('admin.external_id'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('api_release_date')
                    ->label(__('admin.release_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('api_card_count_total')
                    ->label(__('admin.total_cards'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('api_card_count_official')
                    ->label(__('admin.official_cards'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('synchronizeCards')
                    ->label(__('admin.synchronize_set_cards'))
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->iconButton()
                    ->tooltip(__('admin.synchronize_set_cards'))
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.synchronize_set_cards'))
                    ->modalDescription(__('admin.synchronize_set_cards_confirmation'))
                    ->action(function (
                        PokemonTcgSet $record,
                        PokemonTcgCardSync $sync
                    ): void {
                        try {
                            $syncRun = $sync->dispatchSet($record);

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

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}