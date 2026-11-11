<?php

namespace App\Filament\Resources\PokemonTcgSeries\Tables;

use App\Models\PokemonTcgSeries;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PokemonTcgSeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('display_logo_url')
                    ->label(__('admin.logo'))
                    ->height(40)
                    ->width(80)
                    ->state(fn (PokemonTcgSeries $record): ?string => $record->display_logo_url),

                TextColumn::make('external_id')
                    ->label(__('admin.external_id'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('display_name')
                    ->label(__('admin.name'))
                    ->searchable(['name', 'api_name'])
                    ->sortable(),

                TextColumn::make('api_name')
                    ->label(__('admin.api_name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

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