<?php

namespace App\Filament\Resources\VideoScripts\Schemas;

use App\Enums\ArticleStatus;
use App\Services\VideoScriptTranslator;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use RuntimeException;

class VideoScriptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make(__('admin.video_script_general'))
                                    ->schema([
                                        TextInput::make('title')
                                            ->label(__('admin.video_script_title'))
                                            ->required()
                                            ->maxLength(255),

                                        Select::make('platforms')
                                            ->label(__('admin.video_script_platforms'))
                                            ->options([
                                                'youtube' => __('admin.video_script_platform_youtube'),
                                                'youtube_shorts' => __('admin.video_script_platform_youtube_shorts'),
                                                'tiktok' => __('admin.video_script_platform_tiktok'),
                                            ])
                                            ->multiple()
                                            ->required()
                                            ->searchable(),

                                        Select::make('category_id')
                                            ->label(__('admin.video_script_category'))
                                            ->relationship(
                                                name: 'category',
                                                titleAttribute: 'name',
                                                modifyQueryUsing: fn ($query) => $query
                                                    ->where('is_active', true)
                                                    ->orderBy('name')
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                    ]),

                                Section::make(__('admin.video_script_content'))
                                    ->description(__('admin.video_script_content_description'))
                                    ->schema([
                                        RichEditor::make('content')
                                            ->label(__('admin.video_script_editor'))
                                            ->required()
                                            ->columnSpanFull()
                                            ->hintAction(
                                                Action::make('translate')
                                                    ->label(__('admin.video_script_translate'))
                                                    ->icon(Heroicon::Sparkles)
                                                    ->action(function (
                                                        Get $get,
                                                        Set $set,
                                                        VideoScriptTranslator $translator,
                                                    ): void {
                                                        $content = $get('content') ?? '';
                                                        $platforms = $get('platforms') ?? [];

                                                        if (blank(strip_tags($content))) {
                                                            throw new RuntimeException(
                                                                __('admin.video_script_enter_content_first')
                                                            );
                                                        }

                                                        if (blank($platforms)) {
                                                            throw new RuntimeException(
                                                                __('admin.video_script_select_platform_first')
                                                            );
                                                        }

                                                        $translatedContent = $translator->translate(
                                                            sourceHtml: $content,
                                                            platforms: $platforms,
                                                        );

                                                        $set('content', $translatedContent);

                                                        Notification::make()
                                                            ->success()
                                                            ->title(__('admin.video_script_translate_success'))
                                                            ->send();
                                                    })
                                            ),
                                    ]),
                            ])
                            ->columnSpan(2),

                        Group::make()
                            ->schema([
                                Section::make(__('admin.video_script_planning'))
                                    ->schema([
                                        TextInput::make('target_duration')
                                            ->label(__('admin.video_script_target_duration'))
                                            ->helperText(__('admin.video_script_target_duration_help'))
                                            ->numeric()
                                            ->minValue(1)
                                            ->suffix(__('admin.minutes'))
                                            ->afterStateHydrated(
                                                fn (TextInput $component, $state) => $component->state(
                                                    filled($state) ? (int) ($state / 60) : null
                                                )
                                            )
                                            ->dehydrateStateUsing(
                                                fn ($state) => filled($state)
                                                    ? (int) $state * 60
                                                    : null
                                            ),

                                        DateTimePicker::make('published_at')
                                            ->label(__('admin.video_script_published_at')),
                                    ]),

                                Section::make(__('admin.video_script_additional_information'))
                                    ->schema([
                                        Select::make('status')
                                            ->label(__('admin.status'))
                                            ->options(ArticleStatus::class)
                                            ->default(ArticleStatus::Draft)
                                            ->required(),

                                        Textarea::make('notes')
                                            ->label(__('admin.video_script_notes'))
                                            ->helperText(__('admin.video_script_notes_help'))
                                            ->rows(4),
                                    ]),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}