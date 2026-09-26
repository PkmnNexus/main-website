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
                        Section::make('Content')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $set('slug', Str::slug($state));
                                    }),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                RichEditor::make('content')
                                    ->label('Content')
                                    ->required()
                                    ->columnSpanFull()
                                    ->tools([
                                        RichEditorTool::make('assetBrowser')
                                            ->label('Asset browser')
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
                                Section::make('Media')
                                    ->schema([
                                        AssetPicker::make('hero_asset_id')
                                            ->label('Open Graph image'),
                                    ])
                                    ->collapsible(),

                                Section::make('Publishing')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->default(true),
                                    ])
                                    ->collapsible(),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 1,
                            ]),
                    ]),

                Section::make('SEO')
                    ->schema([

                        Textarea::make('meta_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder('Leave empty to use the page content.')
                            ->helperText('Recommended maximum of 160 characters.')
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        TagsInput::make('meta_keywords')
                            ->label('Meta keywords')
                            ->placeholder('Type a keyword and press Enter')
                            ->separator(',')
                            ->helperText('Press Enter after each keyword.')
                            ->columnSpanFull(),

                        TextInput::make('canonical')
                            ->label('Canonical URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://pkmnnexus.com/example')
                            ->helperText('Leave empty to use the page URL.'),

                        Fieldset::make('Robots')
                            ->schema([
                                Toggle::make('robots_index')
                                    ->label('Allow indexing')
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText('Allow search engines to index this page.'),

                                Toggle::make('robots_follow')
                                    ->label('Follow links')
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText('Allow search engines to follow links on this page.'),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),

                Section::make('OG Tags')
                    ->schema([
                        TextInput::make('og_title')
                            ->label('Open Graph title')
                            ->maxLength(60)
                            ->placeholder('Leave empty to use the meta title.')
                            ->helperText('Defaults to the meta title or page title.')
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 60'),

                        Textarea::make('og_description')
                            ->label('Open Graph description')
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder('Leave empty to use the meta description.')
                            ->helperText('Defaults to the meta description or page content.')
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        TextInput::make('og_type')
                            ->label('Open Graph type')
                            ->default('website')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->helperText('Pages use the Website Open Graph type.'),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}