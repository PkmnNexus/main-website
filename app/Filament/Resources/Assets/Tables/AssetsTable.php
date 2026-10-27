<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                SpatieMediaLibraryImageColumn::make('asset')
                    ->label('')
                    ->collection('asset')
                    ->conversion('thumb')
                    ->square()
                    ->size(80),

                TextColumn::make('title')
                    ->label(__('admin.title'))
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->alt),

                TextColumn::make('folder.name')
                    ->label(__('admin.folder'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('dimensions')
                    ->label(__('admin.dimensions'))
                    ->state(fn ($record) => $record->width && $record->height
                        ? "{$record->width} × {$record->height}"
                        : '—'
                    )
                    ->sortable(query: function ($query, string $direction) {
                        return $query->orderBy('width', $direction)
                                     ->orderBy('height', $direction);
                    }),

                TextColumn::make('file_size')
                    ->label(__('admin.size'))
                    ->formatStateUsing(fn (?int $state) => $state
                        ? Number::fileSize($state)
                        : '—'
                    )
                    ->sortable(),

                TextColumn::make('mime_type')
                    ->label(__('admin.type'))
                    ->badge(),

                TextColumn::make('created_at')
                    ->label(__('admin.uploaded'))
                    ->since()
                    ->sortable(),
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