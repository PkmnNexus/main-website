<?php

namespace App\Filament\Resources\MediaFolders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MediaFolderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('admin.folder_name'))
                    ->required()
                    ->maxLength(255),

                Select::make('parent_id')
                    ->label(__('admin.parent_folder'))
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder(__('admin.root_folder')),
            ]);
    }
}