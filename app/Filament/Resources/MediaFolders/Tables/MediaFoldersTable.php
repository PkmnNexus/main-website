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
                    ->label('Folder')
                    ->icon(Heroicon::OutlinedFolder)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.name')
                    ->label('Parent folder')
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('assets_count')
                    ->label('Assets')
                    ->counts('assets')
                    ->numeric()
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
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
            ->emptyStateHeading('No folders found')
            ->emptyStateDescription('Create your first media folder to organize your assets.');
    }
}