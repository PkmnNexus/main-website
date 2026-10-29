<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Forms\Components\Media\AssetPicker;
use App\Models\Page;
use Closure;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
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

        $buildSections = function (?string $locale = null) use (
            $localizationEnabled,
            $defaultLocale,
            $translatedLabel,
        ): array {
            $localized = $localizationEnabled && $locale !== null;

            $field = fn (string $name): string => $localized
                ? "{$name}.{$locale}"
                : $name;

            return [
                Grid::make([
                    'default' => 1,
                    'xl' => 3,
                ])
                    ->columnSpanFull()
                    ->schema([
                        Section::make(__('admin.content'))
                            ->schema([
                                TextInput::make($field('title'))
                                    ->label(
                                        $translatedLabel(
                                            __('admin.title'),
                                            $locale,
                                        ),
                                    )
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
                                    ->label(
                                        $translatedLabel(
                                            __('admin.slug'),
                                            $locale,
                                        ),
                                    )
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->rules([
                                        fn (?Page $record): Closure => function (
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

                                            $query = Page::query()
                                                ->where(
                                                    "slug->{$slugLocale}",
                                                    $value,
                                                );

                                            if ($record) {
                                                $query->where(
                                                    $record->getKeyName(),
                                                    '!=',
                                                    $record->getKey(),
                                                );
                                            }

                                            if ($query->exists()) {
                                                $fail(
                                                    __('admin.slug_already_in_use'),
                                                );
                                            }
                                        },
                                    ]),

                                RichEditor::make($field('content'))
                                    ->label(
                                        $translatedLabel(
                                            __('admin.content'),
                                            $locale,
                                        ),
                                    )
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
                        Textarea::make($field('meta_description'))
                            ->label(
                                $translatedLabel(
                                    __('admin.meta_description'),
                                    $locale,
                                ),
                            )
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(
                                __('admin.page_content_meta_description_placeholder'),
                            )
                            ->helperText(__('admin.meta_description_helper'))
                            ->live()
                            ->hint(
                                fn (?string $state) => strlen($state ?? '') . ' / 160',
                            ),

                        TagsInput::make($field('meta_keywords'))
                            ->label(
                                $translatedLabel(
                                    __('admin.meta_keywords'),
                                    $locale,
                                ),
                            )
                            ->placeholder(__('admin.meta_keywords_placeholder'))
                            ->separator(',')
                            ->helperText(__('admin.meta_keywords_helper'))
                            ->columnSpanFull(),

                        TextInput::make($field('canonical'))
                            ->label(
                                $translatedLabel(
                                    __('admin.canonical_url'),
                                    $locale,
                                ),
                            )
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
                        TextInput::make($field('og_title'))
                            ->label(
                                $translatedLabel(
                                    __('admin.open_graph_title'),
                                    $locale,
                                ),
                            )
                            ->maxLength(60)
                            ->placeholder(__('admin.og_title_placeholder'))
                            ->helperText(__('admin.og_page_title_helper'))
                            ->live()
                            ->hint(
                                fn (?string $state) => strlen($state ?? '') . ' / 60',
                            ),

                        Textarea::make($field('og_description'))
                            ->label(
                                $translatedLabel(
                                    __('admin.open_graph_description'),
                                    $locale,
                                ),
                            )
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder(__('admin.og_description_placeholder'))
                            ->helperText(__('admin.og_page_content_helper'))
                            ->live()
                            ->hint(
                                fn (?string $state) => strlen($state ?? '') . ' / 160',
                            ),

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
            ];
        };

        if (! $localizationEnabled) {
            return $schema->components($buildSections());
        }

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
                ->schema($buildSections($locale));
        }

        return $schema->components([
            Tabs::make('translations')
                ->tabs($tabs)
                ->contained(false)
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'w-full [&_[role=tablist]]:justify-start [&_[role=tablist]]:ml-0',
                ]),
        ]);
    }
}