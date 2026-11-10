<?php

namespace App\Filament\Resources\Trivias\Schemas;

use App\Filament\Forms\Components\Media\AssetPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class TriviaForm
{
    public static function configure(Schema $schema): Schema
    {
        $defaultLocale = config('localization.default', 'en');
        $localizationEnabled = (bool) config('localization.enabled');

        $locales = $localizationEnabled
            ? (
                config('filament-translatable-fields.locales')
                ?: array_keys(config('localization.locales', []))
            )
            : [$defaultLocale];

        $translatedLabel = function (
            string $label,
            string $locale,
        ) use ($localizationEnabled): string|HtmlString {
            if (! $localizationEnabled) {
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

        $translationFields = [];

        foreach ($locales as $locale) {
            $translationFields[$locale] = [
                Textarea::make("fact.{$locale}")
                    ->label($translatedLabel(__('admin.fact'), $locale))
                    ->required()
                    ->rows(6)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ];
        }

        $contentComponents = [];

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
                    ->schema($translationFields[$locale]);
            }

            $contentComponents[] = Tabs::make('translations')
                ->tabs($tabs)
                ->contained(false)
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'w-full [&_[role=tablist]]:justify-start [&_[role=tablist]]:ml-0',
                ]);
        } else {
            $contentComponents = [
                ...$contentComponents,
                ...$translationFields[$defaultLocale],
            ];
        }

        return $schema->components([
            Grid::make([
                'default' => 1,
                'xl' => 3,
            ])
                ->columnSpanFull()
                ->schema([
                    Section::make(__('admin.content'))
                        ->schema($contentComponents)
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

                            Section::make(__('admin.settings'))
                                ->schema([
                                    Toggle::make('is_active')
                                        ->label(__('admin.is_active'))
                                        ->default(true)
                                        ->inline(false),

                                    TextInput::make('sort_order')
                                        ->label(__('admin.sort_order'))
                                        ->numeric()
                                        ->integer()
                                        ->default(0)
                                        ->required(),
                                ])
                                ->collapsible(),
                        ])
                        ->columnSpan([
                            'default' => 1,
                            'xl' => 1,
                        ]),
                ]),
        ]);
    }
}