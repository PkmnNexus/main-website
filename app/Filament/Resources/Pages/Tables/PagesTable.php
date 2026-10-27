<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page')
                    ->label(__('admin.page'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label(__('admin.title'))
                    ->sortable()
                    ->searchable(),

                IconColumn::make('robots_index')
                    ->label(__('admin.allow_indexing'))
                    ->boolean(),

                IconColumn::make('robots_follow')
                    ->label(__('admin.follow_links'))
                    ->boolean(),

                TextColumn::make('canonical')
                    ->label(__('admin.canonical_url'))
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label(__('admin.published'))
                    ->boolean(),
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