<?php

namespace App\Filament\Resources\VideoScripts\Tables;

use App\Enums\ArticleStatus;
use App\Models\VideoScript;
use App\Models\VideoScriptCategory;
use App\Services\VideoScriptPdfService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class VideoScriptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('id')
                    ->label('')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('primary')
                    ->tooltip(__('admin.video_script_download_pdf'))
                    ->action(
                        Action::make('downloadPdf')
                            ->action(
                                fn (VideoScript $record) => app(VideoScriptPdfService::class)
                                    ->download($record)
                            )
                    ),

                TextColumn::make('title')
                    ->label(__('admin.video_script_title'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('status')
                    ->label(__('admin.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof ArticleStatus
                        ? $state->getLabel()
                        : ArticleStatus::tryFrom($state)?->getLabel() ?? $state
                    )
                    ->color(fn ($state) => $state instanceof ArticleStatus
                        ? $state->getColor()
                        : ArticleStatus::tryFrom($state)?->getColor()
                    )
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label(__('admin.video_script_category'))
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('word_count')
                    ->label(__('admin.video_script_word_count'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('estimated_duration')
                    ->label(__('admin.video_script_estimated_duration'))
                    ->formatStateUsing(fn ($state) => $state
                        ? sprintf(
                            '%d:%02d',
                            intdiv((int) $state, 60),
                            (int) $state % 60
                        )
                        : '-'
                    )
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label(__('admin.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('platforms')
                    ->label(__('admin.video_script_platforms'))
                    ->options([
                        'youtube' => __('admin.video_script_platform_youtube'),
                        'youtube_shorts' => __('admin.video_script_platform_youtube_shorts'),
                        'tiktok' => __('admin.video_script_platform_tiktok'),
                    ])
                    ->query(function ($query, array $data) {
                        if (filled($data['value'] ?? null)) {
                            $query->whereJsonContains('platforms', $data['value']);
                        }
                    }),

                SelectFilter::make('category_id')
                    ->label(__('admin.video_script_category'))
                    ->options(
                        fn () => VideoScriptCategory::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->all()
                    ),

                SelectFilter::make('status')
                    ->label(__('admin.status'))
                    ->options(ArticleStatus::class),

                TernaryFilter::make('published_at')
                    ->label(__('admin.video_script_publication_status'))
                    ->nullable()
                    ->trueLabel(__('admin.video_script_published'))
                    ->falseLabel(__('admin.video_script_not_published'))
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('published_at'),
                        false: fn ($query) => $query->whereNull('published_at'),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
