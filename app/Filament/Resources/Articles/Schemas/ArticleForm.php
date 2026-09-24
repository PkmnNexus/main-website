<?php
namespace App\Filament\Resources\Articles\Schemas;

use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

use App\Filament\Forms\Components\Media\AssetPicker;
use App\Services\ArticleMetadataGenerator;
use App\Services\ArticleKeywordGenerator;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use App\Enums\ArticleStatus;

class ArticleForm
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

                                Textarea::make('excerpt')
                                    ->label('Excerpt')
                                    ->required()
                                    ->rows(4)
                                    ->minLength(25)
                                    ->maxLength(225)
                                    ->columnSpanFull()
                                    ->helperText('Used on article overviews and as the default meta description.')
                                    ->live()
                                    ->hint(fn (?string $state) => strlen($state ?? '') . ' / 225'),

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

                                TagsInput::make('tags')
                                    ->label('Tags')
                                    ->placeholder('Add a tag')
                                    ->separator(',')
                                    ->helperText('Press Enter after each tag.')
                                    ->afterStateHydrated(function (TagsInput $component, $record): void {
                                        $component->state(
                                            $record?->tags
                                                ->map(function ($tag) {
                                                    $name = $tag->name;

                                                    if (is_array($name)) {
                                                        $name = $name['en'] ?? reset($name);
                                                    }

                                                    return $name;
                                                })
                                                ->filter()
                                                ->values()
                                                ->toArray() ?? []
                                        );
                                    })
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
                                            ->label('Hero image'),
                                    ])
                                    ->collapsible(),

                                Section::make('Publishing')
                                    ->schema([
                                        TextInput::make('video_url')
                                            ->label('YouTube URL')
                                            ->url()
                                            ->nullable()
                                            ->placeholder('https://www.youtube.com/watch?v=...')
                                            ->maxLength(255)
                                            ->rule('regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[A-Za-z0-9_-]{11}.*$/')
                                            ->validationMessages([
                                                'regex' => 'Please enter a valid YouTube URL.',
                                            ]),

                                        Select::make('category_id')
                                            ->label('Category')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        Select::make('user_id')
                                            ->label('Author')
                                            ->relationship(
                                                name: 'user',
                                                titleAttribute: 'name',
                                                modifyQueryUsing: function (Builder $query) {
                                                    if (Filament::auth()->user()->hasRole('author')) {
                                                        $query->whereKey(Filament::auth()->id());
                                                    }
                                                },
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->hidden(fn () => Filament::auth()->user()->hasRole('author'))
                                            ->dehydrated(),

                                        Select::make('status')
                                            ->label('Status')
                                            ->options(ArticleStatus::class)
                                            ->default(ArticleStatus::Draft)
                                            ->required()
                                            ->hidden(fn () => auth()->user()->hasRole('author'))
                                            ->dehydrated(),

                                        DateTimePicker::make('published_at')
                                            ->label('Published at')
                                            ->seconds(false),

                                        DateTimePicker::make('expires_at')
                                            ->label('Expires at')
                                            ->seconds(false)
                                            ->helperText('Leave empty to keep this article online indefinitely.')
                                            ->rule('after:published_at'),

                                        Toggle::make('is_breaking')
                                            ->label('Breaking News'),

                                        Toggle::make('is_featured')
                                            ->label('Featured'),

                                        Toggle::make('is_pokemon_go_featured')
                                            ->label('Pokémon GO Featured'),
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
                        TextInput::make('meta_title')
                            ->label('Meta title')
                            ->maxLength(60)
                            ->placeholder('Leave empty to use the article title.')
                            ->helperText('Recommended maximum of 60 characters.')
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 60')
                            ->hintAction(
                                Action::make('generateSeoMetadata')
                                    ->label('Generate SEO & OG')
                                    ->icon(Heroicon::Sparkles)
                                    ->action(function (
                                        Get $get,
                                        Set $set,
                                        ArticleMetadataGenerator $generator,
                                    ): void {
                                        $title = $get('title') ?? '';
                                        $excerpt = $get('excerpt') ?? '';
                                        $content = $get('content') ?? '';
                                        $keywords = $get('meta_keywords') ?? [];

                                        if (
                                            blank($title)
                                            && blank($excerpt)
                                            && blank($content)
                                        ) {
                                            throw new \RuntimeException(
                                                'Please enter the article content first.'
                                            );
                                        }

                                        $metadata = $generator->generate(
                                            title: $title,
                                            excerpt: $excerpt,
                                            content: strip_tags($content),
                                            keywords: $keywords,
                                        );

                                        $set('meta_title', $metadata['meta_title']);
                                        $set('meta_description', $metadata['meta_description']);

                                        $set('og_title', $metadata['meta_title']);
                                        $set('og_description', $metadata['meta_description']);
                                    })
                            ),

                        Textarea::make('meta_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder('Leave empty to use the article excerpt.')
                            ->helperText('Recommended maximum of 160 characters.')
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                            TagsInput::make('meta_keywords')
                                ->label('Meta keywords')
                                ->placeholder('Type a keyword and press Enter')
                                ->separator(',')
                                ->helperText('Press Enter after each keyword.')
                                ->hintAction(
                                    Action::make('generateKeywords')
                                        ->label('Genereer met AI')
                                        ->icon(Heroicon::Sparkles)
                                        ->action(function (
                                            Get $get,
                                            Set $set,
                                            ArticleKeywordGenerator $generator,
                                        ) {
                                            $title = $get('title') ?? '';
                                            $excerpt = $get('excerpt') ?? '';
                                            $content = $get('content') ?? '';

                                            if (blank($title) && blank($excerpt) && blank($content)) {
                                                throw new \RuntimeException(
                                                    'First fill in the article information.'
                                                );
                                            }

                                            $keywords = $generator->generate(
                                                title: $title,
                                                excerpt: $excerpt,
                                                content: strip_tags($content),
                                            );

                                            $set('meta_keywords', $keywords);
                                        })
                                )
                                ->columnSpanFull(),

                        TextInput::make('canonical')
                            ->label('Canonical URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://pkmnnexus.com/articles/example')
                            ->helperText('Leave empty to use the article URL.'),

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
                            ->helperText('Defaults to the meta title or article title.')
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 60'),

                        Textarea::make('og_description')
                            ->label('Open Graph description')
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder('Leave empty to use the meta description.')
                            ->helperText('Defaults to the meta description or article excerpt.')
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        Select::make('og_type')
                            ->label('Open Graph type')
                            ->options([
                                'article' => 'Article',
                                'website' => 'Website',
                                'video.other' => 'Video',
                            ])
                            ->default('article')
                            ->required()
                            ->native(false)
                            ->helperText('Select how this content should be presented on social media.'),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}