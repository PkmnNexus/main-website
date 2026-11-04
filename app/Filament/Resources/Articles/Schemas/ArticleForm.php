<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleStatus;
use App\Filament\Forms\Components\Media\AssetPicker;
use App\Models\Article;
use App\Models\Source;
use App\Models\Tag;
use App\Services\ArticleKeywordGenerator;
use App\Services\ArticleMetadataGenerator;
use App\Services\ArticleSummaryGenerator;
use Closure;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Filament::auth()->user();
        $isAuthor = $user?->hasRole('author') ?? false;
        $canManagePublishing = $user?->hasAnyRole(['admin', 'editor']) ?? false;
        $canCreateSources = $canManagePublishing;

        $defaultLocale = config('localization.default', 'en');
        $localizationEnabled = (bool) config('localization.enabled', false);

        $locales = $localizationEnabled
            ? (
                config('filament-translatable-fields.locales')
                ?: array_keys(config('localization.locales', []))
            )
            : [$defaultLocale];

        $translatedLabel = function (
            string $label,
            ?string $locale,
        ) use ($localizationEnabled): string|HtmlString {
            if (! $localizationEnabled || $locale === null) {
                return $label;
            }

            $flag = match ($locale) {
                'en' => 'gb',
                default => $locale,
            };

            $localeLabel = config(
                "filament-translatable-fields.labels.{$locale}",
                strtoupper($locale),
            );

            $flagSvg = svg(
                "flag-country-{$flag}",
                'h-3.5 w-5',
                [
                    'title' => $localeLabel,
                    'aria-label' => $localeLabel,
                ],
            );

            return new HtmlString(
                '<span class="inline-flex items-center gap-2">'
                    . '<span>' . e($label) . '</span>'
                    . '<span class="inline-flex items-center opacity-70">'
                    . $flagSvg->toHtml()
                    . '</span>'
                    . '</span>',
            );
        };

        $buildTab = function (string $locale) use (
            $localizationEnabled,
            $defaultLocale,
            $translatedLabel,
        ): array {
            $localized = $localizationEnabled;
        $field = fn (string $name): string => $localized
            ? "{$name}.{$locale}"
            : $name;

        $contentField = $field('content');

            return [
                Section::make(__('admin.content'))
                    ->schema([
                        TextInput::make($field('title'))
                            ->label($translatedLabel(__('admin.title'), $locale))
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn (Set $set, ?string $state) => $set(
                                    $field('slug'),
                                    Str::slug($state ?? ''),
                                ),
                            ),

                        TextInput::make($field('slug'))
                            ->label($translatedLabel(__('admin.slug'), $locale))
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255)
                            ->rules([
                                fn (?Article $record): Closure => function (
                                    string $attribute,
                                    mixed $value,
                                    Closure $fail,
                                ) use (
                                    $record,
                                    $locale,
                                    $localized,
                                    $defaultLocale,
                                ): void {
                                    $slugLocale = $localized
                                        ? $locale
                                        : $defaultLocale;

                                    $query = Article::query()
                                        ->where("slug->{$slugLocale}", $value);

                                    if ($record) {
                                        $query->where(
                                            $record->getKeyName(),
                                            '!=',
                                            $record->getKey(),
                                        );
                                    }

                                    if ($query->exists()) {
                                        $fail(__('admin.slug_already_in_use'));
                                    }
                                },
                            ]),

                        Textarea::make($field('excerpt'))
                            ->label($translatedLabel(__('admin.excerpt'), $locale))
                            ->required()
                            ->rows(4)
                            ->minLength(25)
                            ->maxLength(225)
                            ->columnSpanFull()
                            ->helperText(__('admin.excerpt_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 225'),

                        Textarea::make($field('summary'))
                            ->label($translatedLabel(__('admin.summary'), $locale))
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
                                    ) use ($field): void {
                                        $title = $get($field('title')) ?? '';
                                        $excerpt = $get($field('excerpt')) ?? '';
                                        $content = $get($field('content')) ?? '';

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

                                        $set($field('summary'), $summary);
                                    })
                            ),

                        RichEditor::make($contentField)
                            ->label($translatedLabel(__('admin.content'), $locale))
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
                    ])
                    ->columnSpanFull()
                    ->collapsible(),
            ];
        };

        $buildMetadataTab = function (string $locale) use (
            $localizationEnabled,
            $defaultLocale,
            $translatedLabel,
        ): array {
            $localized = $localizationEnabled;
            $field = fn (string $name): string => $localized
                ? "{$name}.{$locale}"
                : $name;

            return [
                Section::make(__('admin.seo'))
                    ->schema([
                        TextInput::make($field('meta_title'))
                            ->label($translatedLabel(__('admin.meta_title'), $locale))
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
                                    ) use ($field): void {
                                        $title = $get($field('title')) ?? '';
                                        $excerpt = $get($field('excerpt')) ?? '';
                                        $content = $get($field('content')) ?? '';
                                        $keywords = $get($field('meta_keywords')) ?? [];

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

                                        $set($field('meta_title'), $metadata['meta_title']);
                                        $set($field('meta_description'), $metadata['meta_description']);
                                        $set($field('og_title'), $metadata['meta_title']);
                                        $set($field('og_description'), $metadata['meta_description']);
                                    })
                            ),

                        Textarea::make($field('meta_description'))
                            ->label($translatedLabel(__('admin.meta_description'), $locale))
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(__('admin.meta_description_placeholder'))
                            ->helperText(__('admin.meta_description_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        \Filament\Forms\Components\TagsInput::make($field('meta_keywords'))
                            ->label($translatedLabel(__('admin.meta_keywords'), $locale))
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
                                    ) use ($field) {
                                        $title = $get($field('title')) ?? '';
                                        $excerpt = $get($field('excerpt')) ?? '';
                                        $content = $get($field('content')) ?? '';

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

                                        $set($field('meta_keywords'), $keywords);
                                    })
                            )
                            ->columnSpanFull(),

                        TextInput::make($field('canonical'))
                            ->label($translatedLabel(__('admin.canonical_url'), $locale))
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://pkmnnexus.com/articles/example')
                            ->helperText(__('admin.canonical_url_helper')),

                        ...($locale === $defaultLocale ? [
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
                        ] : []),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),

                Section::make(__('admin.og_tags'))
                    ->schema([
                        TextInput::make($field('og_title'))
                            ->label($translatedLabel(__('admin.open_graph_title'), $locale))
                            ->maxLength(60)
                            ->placeholder(__('admin.og_title_placeholder'))
                            ->helperText(__('admin.og_title_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 60'),

                        Textarea::make($field('og_description'))
                            ->label($translatedLabel(__('admin.open_graph_description'), $locale))
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(__('admin.og_description_placeholder'))
                            ->helperText(__('admin.og_description_helper'))
                            ->live()
                            ->hint(fn (?string $state) => strlen($state ?? '') . ' / 160'),

                        ...($locale === $defaultLocale ? [
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
                        ] : []),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed(),
            ];
        };

        $buildTagsSection = function () use (
            $locales,
            $localizationEnabled,
            $defaultLocale,
        ): Section {
            $buildTagField = function (?string $locale = null) use (
                $localizationEnabled,
                $defaultLocale,
            ): TagsInput {
                $field = $localizationEnabled ? "tags.{$locale}" : 'tags';
                $tagLocale = $locale ?? $defaultLocale;

                return TagsInput::make($field)
                    ->placeholder(__('admin.add_a_tag'))
                    ->afterStateHydrated(function (
                        TagsInput $component,
                        ?Article $record,
                    ) use ($tagLocale): void {
                        $component->state(
                            $record?->tags
                                ->flatMap(function (Tag $tag) use ($tagLocale): array {
                                    $name = $tag->getTranslation('name', $tagLocale, false);

                                    if (blank($name)) {
                                        return [];
                                    }

                                    return collect(preg_split('/\s*,\s*/u', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY))
                                        ->map(fn (string $value): string => trim($value))
                                        ->filter()
                                        ->all();
                                })
                                ->unique()
                                ->values()
                                ->all() ?? []
                        );
                    })
                    ->columnSpanFull();
            };

            $schema = [];

            if ($localizationEnabled) {
                $tabs = [];

                foreach ($locales as $locale) {
                    $label = config(
                        "filament-translatable-fields.labels.{$locale}",
                        strtoupper($locale),
                    );

                    $flag = match ($locale) {
                        'en' => 'gb',
                        default => $locale,
                    };

                    $flagSvg = svg(
                        "flag-country-{$flag}",
                        'h-5 w-7',
                        [
                            'title' => $label,
                            'aria-label' => $label,
                        ],
                    );

                    $tabs[] = Tab::make($locale)
                        ->label(new HtmlString($flagSvg->toHtml()))
                        ->schema([
                            $buildTagField($locale),
                        ]);
                }

                $schema[] = Tabs::make('tag_translations')
                    ->tabs($tabs)
                    ->contained(false);
            } else {
                $schema[] = $buildTagField();
            }

            return Section::make(__('admin.tags'))
                ->schema($schema)
                ->collapsible();
        };

        $buildMediaAndPublishing = function () use (
            $isAuthor,
            $canManagePublishing,
            $buildTagsSection,
        ): array {
            return [
                Section::make(__('admin.media'))
                    ->schema([
                        AssetPicker::make('hero_asset_id')
                            ->label(__('admin.hero_image')),
                    ])
                    ->collapsible(),

                $buildTagsSection(),

                Section::make(__('admin.publishing'))
                    ->schema([
                        TextInput::make('video_url')
                            ->label(__('admin.youtube_url'))
                            ->url()
                            ->nullable()
                            ->live(onBlur: true)
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->maxLength(255)
                            ->rule('regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[A-Za-z0-9_-]{11}.*$/')
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
            ];
        };

        $buildLocaleSchema = function (string $locale) use (
            $buildTab,
            $buildMetadataTab,
            $buildMediaAndPublishing,
        ): array {
            return [
                Grid::make([
                    'default' => 1,
                    'xl' => 3,
                ])
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                ...$buildTab($locale),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 2,
                            ]),

                        Grid::make(1)
                            ->schema($buildMediaAndPublishing())
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 1,
                            ]),

                        ...$buildMetadataTab($locale),
                    ]),
            ];
        };

        $tabComponents = [];

        if ($localizationEnabled) {
            $tabs = [];

            foreach ($locales as $locale) {
                $label = config(
                    "filament-translatable-fields.labels.{$locale}",
                    strtoupper($locale),
                );

                $flag = match ($locale) {
                    'en' => 'gb',
                    default => $locale,
                };

                $flagSvg = svg(
                    "flag-country-{$flag}",
                    'h-5 w-7',
                    [
                        'title' => $label,
                        'aria-label' => $label,
                    ],
                );

                $tabs[] = Tab::make($locale)
                    ->label(new HtmlString($flagSvg->toHtml()))
                    ->schema($buildLocaleSchema($locale));
            }

            $tabComponents[] = Tabs::make('translations')
                ->tabs($tabs)
                ->contained(false)
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'w-full [&_[role=tablist]]:justify-start [&_[role=tablist]]:ml-0',
                ]);
        } else {
            $tabComponents = $buildLocaleSchema($defaultLocale);
        }

        return $schema
            ->components([
                ...$tabComponents,

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

            ]);
    }
}