<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Forms\Components\Media\AssetPicker;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'xl' => 3,
                ])
                    ->columnSpanFull()
                    ->schema([
                        Section::make(__('admin.content'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('admin.title'))
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $set('slug', Str::slug($state));
                                    }),

                                TextInput::make('slug')
                                    ->label(__('admin.slug'))
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                RichEditor::make('content')
                                    ->label(__('admin.content'))
                                    ->required()
                                    ->columnSpanFull()
                                    ->tools([
                                        RichEditorTool::make('assetBrowser')
                                            ->label(__('admin.asset_browser'))
                                            ->icon(Heroicon::Photo)
                                            ->jsHandler(<<<'JS'
                                                (() => {
                                                    const editor = $getEditor();

                                                    if (! editor) {
                                                        return;
                                                    }

                                                    window.__pkmNexusAssetEditor = editor;

                                                    window.__pkmNexusAssetPosition = {
                                                        from: editor.state.selection.from,
                                                        to: editor.state.selection.to,
                                                    };

                                                    window.dispatchEvent(new CustomEvent('open-modal', {
                                                        detail: { id: 'asset-browser' },
                                                    }));
                                                })()
                                            JS),
                                    ])
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'h2',
                                        'h3',
                                        'bulletList',
                                        'orderedList',
                                        'blockquote',
                                        'codeBlock',
                                        'undo',
                                        'redo',
                                        'assetBrowser',
                                    ]),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 2,
                            ])
                            ->collapsible(),

                        Grid::make(1)
                            ->schema([
                                Section::make(__('admin.media'))
                                    ->schema([
                                        AssetPicker::make('hero_asset_id')
                                            ->label(__('admin.open_graph_image')),
                                    ])
                                    ->collapsible(),

                                Section::make(__('admin.publishing'))
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label(__('admin.active'))
                                            ->default(true),
                                    ])
                                    ->collapsible(),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 1,
                            ]),
                    ]),

                Section::make(__('admin.seo'))
                    ->schema([
                        Textarea::make('meta_description')
                            ->label(__('admin.meta_description'))
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(__('admin.page_content_meta_description_placeholder'))
                            ->helperText(__('admin.meta_description_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        TagsInput::make('meta_keywords')
                            ->label(__('admin.meta_keywords'))
                            ->placeholder(__('admin.meta_keywords_placeholder'))
                            ->separator(',')
                            ->helperText(__('admin.meta_keywords_helper'))
                            ->columnSpanFull(),

                        TextInput::make('canonical')
                            ->label(__('admin.canonical_url'))
                            ->url()
                            ->maxLength(255)
                            ->placeholder(__('admin.canonical_url_placeholder'))
                            ->helperText(__('admin.page_canonical_url_helper')),

                        Fieldset::make(__('admin.robots'))
                            ->schema([
                                Toggle::make('robots_index')
                                    ->label(__('admin.allow_indexing'))
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText(__('admin.allow_indexing_helper')),

                                Toggle::make('robots_follow')
                                    ->label(__('admin.follow_links'))
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText(__('admin.follow_links_helper')),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),

                Section::make(__('admin.og_tags'))
                    ->schema([
                        TextInput::make('og_title')
                            ->label(__('admin.open_graph_title'))
                            ->maxLength(60)
                            ->placeholder(__('admin.og_title_placeholder'))
                            ->helperText(__('admin.og_page_title_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 60'),

                        Textarea::make('og_description')
                            ->label(__('admin.open_graph_description'))
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(__('admin.og_description_placeholder'))
                            ->helperText(__('admin.og_page_content_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        TextInput::make('og_type')
                            ->label(__('admin.open_graph_type'))
                            ->default('website')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->helperText(__('admin.page_og_type_helper')),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}