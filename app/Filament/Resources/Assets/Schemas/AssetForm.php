<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Image')
                ->description('Upload an image.')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('asset')
                        ->label('Image')
                        ->collection('asset')
                        ->image()
                        ->imageEditor()
                        ->responsiveImages()
                        ->required()
                        ->maxSize(10240)
                        ->acceptedFileTypes([
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/avif',
                        ])
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            if (! $state || filled($get('title'))) {
                                return;
                            }

                            if (method_exists($state, 'getClientOriginalName')) {
                                $filename = pathinfo(
                                    $state->getClientOriginalName(),
                                    PATHINFO_FILENAME
                                );

                                $set('title', Str::headline($filename));
                            }
                        }),
                ]),

                Section::make('Metadata')
                    ->description('General information.')
                    ->schema([
                        Select::make('media_folder_id')
                            ->label('Folder')
                            ->relationship('folder', 'name')
                            ->searchable()
                            ->preload(),

                        TextInput::make('title')
                            ->label('Title')
                            ->maxLength(255),

                        TextInput::make('alt')
                            ->label('Alt text')
                            ->maxLength(255),

                        Textarea::make('caption')
                            ->label('Caption')
                            ->rows(3),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5),
                    ]),

                Section::make('Credits')
                    ->description('Copyright information.')
                    ->schema([
                        TextInput::make('photographer')
                            ->label('Photographer'),

                        TextInput::make('copyright')
                            ->label('Copyright'),
                    ]),
            ]);
    }
}