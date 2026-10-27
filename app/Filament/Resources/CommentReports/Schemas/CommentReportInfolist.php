<?php

namespace App\Filament\Resources\CommentReports\Schemas;

use App\Models\CommentReport;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CommentReportInfolist
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the report details.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                /*
                |--------------------------------------------------------------------------
                | Report Details
                |--------------------------------------------------------------------------
                */

                Section::make(__('admin.report_details'))
                    ->description(__('admin.report_details_description'))
                    ->icon('heroicon-o-flag')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('admin.report_id'))
                            ->copyable(),

                        TextEntry::make('status')
                            ->label(__('admin.status'))
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                CommentReport::STATUS_PENDING => __('admin.pending'),
                                CommentReport::STATUS_REVIEWING => __('admin.reviewing'),
                                CommentReport::STATUS_RESOLVED => __('admin.resolved'),
                                CommentReport::STATUS_DISMISSED => __('admin.dismissed'),
                                default => str($state)->headline()->toString(),
                            })
                            ->color(fn (string $state): string => match ($state) {
                                CommentReport::STATUS_PENDING => 'warning',
                                CommentReport::STATUS_REVIEWING => 'info',
                                CommentReport::STATUS_RESOLVED => 'success',
                                CommentReport::STATUS_DISMISSED => 'gray',
                                default => 'gray',
                            }),

                        TextEntry::make('reason')
                            ->label(__('admin.reason'))
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'spam' => __('admin.spam_or_advertising'),
                                'harassment' => __('admin.harassment_or_bullying'),
                                'hate_speech' => __('admin.hate_speech'),
                                'inappropriate_content' => __('admin.inappropriate_content'),
                                'other' => __('admin.other'),
                                default => str($state)->headline()->toString(),
                            }),

                        TextEntry::make('created_at')
                            ->label(__('admin.reported_at'))
                            ->dateTime()
                            ->since(),

                        TextEntry::make('details')
                            ->label(__('admin.additional_details'))
                            ->placeholder(__('admin.no_additional_details_provided'))
                            ->columnSpanFull(),
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Reported Comment
                |--------------------------------------------------------------------------
                */

                Section::make(__('admin.reported_comment'))
                    ->description(__('admin.reported_comment_description'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextEntry::make('comment.article.title')
                            ->label(__('admin.article'))
                            ->placeholder(__('admin.article_unavailable'))
                            ->columnSpanFull(),

                        TextEntry::make('comment.body')
                            ->label(__('admin.comment'))
                            ->placeholder(__('admin.comment_unavailable'))
                            ->columnSpanFull()
                            ->prose(),
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Reporter Information
                |--------------------------------------------------------------------------
                */

                Section::make(__('admin.reporter_information'))
                    ->description(__('admin.reporter_information_description'))
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('reporter.display_name')
                            ->label(__('admin.registered_user'))
                            ->placeholder(__('admin.guest_reporter'))
                            ->visible(fn (CommentReport $record): bool => $record->user_id !== null),

                        TextEntry::make('first_name')
                            ->label(__('admin.first_name'))
                            ->placeholder('—')
                            ->visible(fn (CommentReport $record): bool => $record->user_id === null),

                        TextEntry::make('last_name')
                            ->label(__('admin.last_name'))
                            ->placeholder('—')
                            ->visible(fn (CommentReport $record): bool => $record->user_id === null),

                        TextEntry::make('email')
                            ->label(__('admin.email_address'))
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Review Information
                |--------------------------------------------------------------------------
                */

                Section::make(__('admin.review_information'))
                    ->description(__('admin.review_information_description'))
                    ->icon('heroicon-o-clipboard-document-check')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('reviewer.display_name')
                            ->label(__('admin.reviewed_by'))
                            ->placeholder(__('admin.not_reviewed_yet')),

                        TextEntry::make('reviewed_at')
                            ->label(__('admin.last_status_change'))
                            ->dateTime()
                            ->placeholder('—'),
                    ])
                    ->collapsed(),
            ]);
    }
}