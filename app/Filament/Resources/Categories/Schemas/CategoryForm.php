<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Closure;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CategoryForm
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

        $translatedLabel = function (string $label, string $locale) use (
            $localizationEnabled,
        ): string|HtmlString {
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
                TextInput::make("name.{$locale}")
                    ->label($translatedLabel(__('admin.name'), $locale))
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn (Set $set, ?string $state) => $set(
                            "slug.{$locale}",
                            Str::slug($state ?? ''),
                        ),
                    ),

                TextInput::make("slug.{$locale}")
                    ->label($translatedLabel(__('admin.slug'), $locale))
                    ->required()
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated()
                    ->rules([
                        fn (?Category $record): Closure => function (
                            string $attribute,
                            mixed $value,
                            Closure $fail,
                        ) use ($record, $locale): void {
                            $query = Category::query()
                                ->where("slug->{$locale}", $value);

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

                Textarea::make("description.{$locale}")
                    ->label($translatedLabel(__('admin.description'), $locale))
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ];
        }

        $components = [];

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

            $components[] = Tabs::make('translations')
                ->tabs($tabs)
                ->contained(false)
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'w-full [&_[role=tablist]]:justify-start [&_[role=tablist]]:ml-0',
                ]);
        } else {
            $components = [
                ...$components,
                ...$translationFields[$defaultLocale],
            ];
        }

        $components[] = TextInput::make('key')
            ->label(__('admin.key'))
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true)
            ->alphaDash();

        return $schema->components($components);
    }
}