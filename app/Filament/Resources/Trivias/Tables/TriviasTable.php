<?php

namespace App\Filament\Resources\Trivias\Tables;

use Asignua\FilamentTranslatableFields\Tables\TranslatableColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TriviasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TranslatableColumn::make('fact')
                    ->label(__('admin.fact')),

                IconColumn::make('is_active')
                    ->label(__('admin.is_active'))
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label(__('admin.sort_order'))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('admin.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
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