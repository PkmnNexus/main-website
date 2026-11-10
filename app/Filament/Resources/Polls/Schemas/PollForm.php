<?php

namespace App\Filament\Resources\Polls\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PollForm
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
                TextInput::make("question.{$locale}")
                    ->label($translatedLabel(__('admin.question'), $locale))
                    ->required()
                    ->maxLength(255),

                Textarea::make("description.{$locale}")
                    ->label($translatedLabel(__('admin.description'), $locale))
                    ->rows(4)
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

        $components[] = Section::make(__('admin.poll_options'))
            ->schema([
                Repeater::make('options')
                    ->relationship()
                    ->label(__('admin.poll_options'))
                    ->schema(
                        collect($locales)
                            ->map(fn (string $locale) => TextInput::make("label.{$locale}")
                                ->label($translatedLabel(__('admin.option'), $locale))
                                ->required()
                                ->maxLength(255))
                            ->all()
                    )
                    ->columns($localizationEnabled ? 2 : 1)
                    ->minItems(2)
                    ->defaultItems(2)
                    ->reorderable()
                    ->addActionLabel(__('admin.add_option'))
                    ->collapsible()
                    ->columnSpanFull(),
            ])
            ->columnSpanFull();

        $components[] = Section::make(__('admin.poll_settings'))
            ->schema([
                Toggle::make('is_active')
                    ->label(__('admin.is_active'))
                    ->default(false),

                Toggle::make('show_results_before_vote')
                    ->label(__('admin.show_results_before_vote'))
                    ->default(false),

                DateTimePicker::make('starts_at')
                    ->label(__('admin.starts_at'))
                    ->seconds(false),

                DateTimePicker::make('ends_at')
                    ->label(__('admin.ends_at'))
                    ->seconds(false)
                    ->afterOrEqual('starts_at'),
            ])
            ->columns(2)
            ->columnSpanFull();

        return $schema->components($components);
    }
}