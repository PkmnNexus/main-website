<?php

namespace App\Filament\Resources\MediaFolders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaFoldersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('admin.folder'))
                    ->icon(Heroicon::OutlinedFolder)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.name')
                    ->label(__('admin.parent_folder'))
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('assets_count')
                    ->label(__('admin.assets'))
                    ->counts('assets')
                    ->numeric()
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('admin.updated'))
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
            ])
            ->emptyStateIcon(Heroicon::OutlinedFolder)
            ->emptyStateHeading(__('admin.no_folders_found'))
            ->emptyStateDescription(__('admin.create_first_media_folder'));
    }
}