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
                Section::make(__('admin.image'))
                    ->description(__('admin.upload_an_image'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('asset')
                            ->label(__('admin.image'))
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

                Section::make(__('admin.metadata'))
                    ->description(__('admin.general_information'))
                    ->schema([
                        Select::make('media_folder_id')
                            ->label(__('admin.folder'))
                            ->relationship('folder', 'name')
                            ->searchable()
                            ->preload(),

                        TextInput::make('title')
                            ->label(__('admin.title'))
                            ->maxLength(255),

                        TextInput::make('alt')
                            ->label(__('admin.alt_text'))
                            ->maxLength(255),

                        Textarea::make('caption')
                            ->label(__('admin.caption'))
                            ->rows(3),

                        Textarea::make('description')
                            ->label(__('admin.description'))
                            ->rows(5),
                    ]),

                Section::make(__('admin.credits'))
                    ->description(__('admin.copyright_information'))
                    ->schema([
                        TextInput::make('photographer')
                            ->label(__('admin.photographer')),

                        TextInput::make('copyright')
                            ->label(__('admin.copyright')),
                    ]),
            ]);
    }
}