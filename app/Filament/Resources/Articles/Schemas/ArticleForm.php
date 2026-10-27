<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleStatus;
use App\Filament\Forms\Components\Media\AssetPicker;
use App\Models\Source;
use App\Services\ArticleKeywordGenerator;
use App\Services\ArticleMetadataGenerator;
use App\Services\ArticleSummaryGenerator;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Forms\Components\Select;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Filament::auth()->user();
        $isAuthor = $user?->hasRole('author') ?? false;
        $canManagePublishing = $user?->hasAnyRole(['admin', 'editor']) ?? false;
        $canCreateSources = $canManagePublishing;

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

                                Textarea::make('excerpt')
                                    ->label(__('admin.excerpt'))
                                    ->required()
                                    ->rows(4)
                                    ->minLength(25)
                                    ->maxLength(225)
                                    ->columnSpanFull()
                                    ->helperText(__('admin.excerpt_helper'))
                                    ->live()
                                    ->hint(fn (?string $state) => strlen($state ?? '') . ' / 225'),

                                Textarea::make('summary')
                                    ->label(__('admin.summary'))
                                    ->rows(4)
                                    ->maxLength(600)
                                    ->columnSpanFull()
                                    ->placeholder(__('admin.summary_placeholder'))
                                    ->helperText(__('admin.summary_helper'))
                                    ->live()
                                    ->hint(fn (?string $state) => strlen($state ?? '') . ' / 600')
                                    ->hintAction(
                                        Action::make('generateSummary')
                                            ->label(__('admin.generate_with_ai'))
                                            ->icon(Heroicon::Sparkles)
                                            ->action(function (
                                                Get $get,
                                                Set $set,
                                                ArticleSummaryGenerator $generator,
                                            ): void {
                                                $title = $get('title') ?? '';
                                                $excerpt = $get('excerpt') ?? '';
                                                $content = $get('content') ?? '';

                                                if (
                                                    blank($title)
                                                    && blank($excerpt)
                                                    && blank($content)
                                                ) {
                                                    throw new \RuntimeException(
                                                        __('admin.first_fill_in_article_information')
                                                    );
                                                }

                                                $summary = $generator->generate(
                                                    title: $title,
                                                    excerpt: $excerpt,
                                                    content: strip_tags($content),
                                                );

                                                $set('summary', $summary);
                                            })
                                    ),

                                RichEditor::make('content')
                                    ->label(__('admin.content'))
                                    ->required(fn (Get $get): bool => blank($get('video_url')))
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

                                TagsInput::make('tags')
                                    ->label(__('admin.tags'))
                                    ->placeholder(__('admin.add_a_tag'))
                                    ->separator(',')
                                    ->helperText(__('admin.press_enter_after_each_tag'))
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
                                Section::make(__('admin.media'))
                                    ->schema([
                                        AssetPicker::make('hero_asset_id')
                                            ->label(__('admin.hero_image')),
                                    ])
                                    ->collapsible(),

                                Section::make(__('admin.publishing'))
                                    ->schema([
                                        TextInput::make('video_url')
                                            ->label(__('admin.youtube_url'))
                                            ->url()
                                            ->nullable()
                                            ->live(onBlur: true)
                                            ->placeholder('https://www.youtube.com/watch?v=...')
                                            ->maxLength(255)
                                            ->rule('regex:/^(https?:\\/\\/)?(www\\.)?(youtube\\.com\\/watch\\?v=|youtu\\.be\\/)[A-Za-z0-9_-]{11}.*$/')
                                            ->validationMessages([
                                                'regex' => __('admin.valid_youtube_url'),
                                            ]),

                                        Select::make('category_id')
                                            ->label(__('admin.category'))
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        Select::make('user_id')
                                            ->label(__('admin.author'))
                                            ->relationship(
                                                name: 'user',
                                                titleAttribute: 'name',
                                                modifyQueryUsing: function (Builder $query) use ($isAuthor) {
                                                    $query->whereHas('roles', function (Builder $query) {
                                                        $query->whereIn('name', ['admin', 'editor', 'author']);
                                                    });

                                                    if ($isAuthor) {
                                                        $query->whereKey(Filament::auth()->id());
                                                    }
                                                },
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->hidden(fn () => $isAuthor)
                                            ->dehydrated(),

                                        Select::make('status')
                                            ->label(__('admin.status'))
                                            ->options(ArticleStatus::class)
                                            ->default(ArticleStatus::Draft)
                                            ->required()
                                            ->hidden(fn () => ! $canManagePublishing)
                                            ->dehydrated(),

                                        DateTimePicker::make('published_at')
                                            ->label(__('admin.published_at'))
                                            ->seconds(false)
                                            ->visible(fn () => $canManagePublishing),

                                        DateTimePicker::make('expires_at')
                                            ->label(__('admin.expires_at'))
                                            ->seconds(false)
                                            ->helperText(__('admin.expires_at_helper'))
                                            ->rule('after:published_at')
                                            ->visible(fn () => $canManagePublishing),

                                        Toggle::make('is_breaking')
                                            ->label(__('admin.breaking_news'))
                                            ->visible(fn () => $canManagePublishing),

                                        Toggle::make('is_featured')
                                            ->label(__('admin.featured'))
                                            ->visible(fn () => $canManagePublishing),

                                        Toggle::make('is_pokemon_go_featured')
                                            ->label(__('admin.pokemon_go_featured'))
                                            ->visible(fn () => $canManagePublishing),
                                    ])
                                    ->collapsible(),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 1,
                            ]),
                    ]),

                Section::make(__('admin.sources'))
                    ->schema([
                        Select::make('sources')
                            ->label(__('admin.sources'))
                            ->relationship(titleAttribute: 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm($canCreateSources ? [
                                TextInput::make('name')
                                    ->label(__('admin.name'))
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('url')
                                    ->label(__('admin.url'))
                                    ->url()
                                    ->required()
                                    ->maxLength(255),
                            ] : [])
                            ->createOptionUsing(function (array $data): int {
                                abort_unless(
                                    Filament::auth()->user()?->hasAnyRole(['admin', 'editor']),
                                    403,
                                );

                                $baseSlug = Str::slug($data['name']);
                                $slug = $baseSlug;
                                $suffix = 2;

                                while (Source::query()->where('slug', $slug)->exists()) {
                                    $slug = $baseSlug . '-' . $suffix++;
                                }

                                $source = Source::query()->create([
                                    'name' => $data['name'],
                                    'slug' => $slug,
                                    'url' => $data['url'],
                                ]);

                                return (int) $source->getKey();
                            })
                            ->helperText(__('admin.sources_helper')),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),

                Section::make(__('admin.seo'))
                    ->schema([
                        TextInput::make('meta_title')
                            ->label(__('admin.meta_title'))
                            ->maxLength(60)
                            ->placeholder(__('admin.meta_title_placeholder'))
                            ->helperText(__('admin.meta_title_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 60')
                            ->hintAction(
                                Action::make('generateSeoMetadata')
                                    ->label(__('admin.generate_seo_og'))
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
                                                __('admin.please_enter_article_content_first')
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
                            ->label(__('admin.meta_description'))
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(__('admin.meta_description_placeholder'))
                            ->helperText(__('admin.meta_description_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        TagsInput::make('meta_keywords')
                            ->label(__('admin.meta_keywords'))
                            ->placeholder(__('admin.meta_keywords_placeholder'))
                            ->separator(',')
                            ->helperText(__('admin.meta_keywords_helper'))
                            ->hintAction(
                                Action::make('generateKeywords')
                                    ->label(__('admin.generate_with_ai'))
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
                                                __('admin.first_fill_in_article_information')
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
                            ->label(__('admin.canonical_url'))
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://pkmnnexus.com/articles/example')
                            ->helperText(__('admin.canonical_url_helper')),

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
                            ->helperText(__('admin.og_title_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 60'),

                        Textarea::make('og_description')
                            ->label(__('admin.open_graph_description'))
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(__('admin.og_description_placeholder'))
                            ->helperText(__('admin.og_description_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        Select::make('og_type')
                            ->label(__('admin.open_graph_type'))
                            ->options([
                                'article' => __('admin.article'),
                                'website' => __('admin.website'),
                                'video.other' => __('admin.video'),
                            ])
                            ->default('article')
                            ->required()
                            ->native(false)
                            ->helperText(__('admin.open_graph_type_helper')),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}