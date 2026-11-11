<?php

namespace App\Filament\Resources\PokemonTcgSets\Tables;

use App\Models\PokemonTcgSet;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PokemonTcgSetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('display_logo_url')
                    ->label(__('admin.logo'))
                    ->height(40)
                    ->width(80)
                    ->state(fn (PokemonTcgSet $record): ?string => $record->display_logo_url),

                ImageColumn::make('display_symbol_url')
                    ->label(__('admin.symbol'))
                    ->height(40)
                    ->width(40)
                    ->state(fn (PokemonTcgSet $record): ?string => $record->display_symbol_url),

                TextColumn::make('external_id')
                    ->label(__('admin.external_id'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('display_name')
                    ->label(__('admin.name'))
                    ->searchable(['name', 'api_name'])
                    ->sortable(),

                TextColumn::make('series.display_name')
                    ->label(__('admin.series'))
                    ->searchable()
                    ->sortable(),

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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}