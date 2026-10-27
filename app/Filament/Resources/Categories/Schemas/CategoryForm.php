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
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label(__('admin.key'))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->alphaDash(),

                Tabs::make('translations')
                    ->tabs([
                        Tab::make(config('filament-translatable-fields.labels.nl', 'Nederlands'))
                            ->schema([
                                TextInput::make('name.nl')
                                    ->label(__('admin.name'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn (Set $set, ?string $state) => $set(
                                            'slug.nl',
                                            Str::slug($state ?? ''),
                                        ),
                                    ),

                                TextInput::make('slug.nl')
                                    ->label(__('admin.slug'))
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->rules([
                                        fn (?Category $record): Closure => function (
                                            string $attribute,
                                            mixed $value,
                                            Closure $fail,
                                        ) use ($record): void {
                                            $query = Category::query()
                                                ->where('slug->nl', $value);

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

                                Textarea::make('description.nl')
                                    ->label(__('admin.description'))
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make(config('filament-translatable-fields.labels.en', 'English'))
                            ->schema([
                                TextInput::make('name.en')
                                    ->label(__('admin.name'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn (Set $set, ?string $state) => $set(
                                            'slug.en',
                                            Str::slug($state ?? ''),
                                        ),
                                    ),

                                TextInput::make('slug.en')
                                    ->label(__('admin.slug'))
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->rules([
                                        fn (?Category $record): Closure => function (
                                            string $attribute,
                                            mixed $value,
                                            Closure $fail,
                                        ) use ($record): void {
                                            $query = Category::query()
                                                ->where('slug->en', $value);

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

                                Textarea::make('description.en')
                                    ->label(__('admin.description'))
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}