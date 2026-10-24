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

                Section::make('Report details')
                    ->description('The reason and details provided with this report.')
                    ->icon('heroicon-o-flag')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('id')
                            ->label('Report ID')
                            ->copyable(),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                CommentReport::STATUS_PENDING => 'Pending',
                                CommentReport::STATUS_REVIEWING => 'Reviewing',
                                CommentReport::STATUS_RESOLVED => 'Resolved',
                                CommentReport::STATUS_DISMISSED => 'Dismissed',
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
                            ->label('Reason')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'spam' => 'Spam or advertising',
                                'harassment' => 'Harassment or bullying',
                                'hate_speech' => 'Hate speech',
                                'inappropriate_content' => 'Inappropriate content',
                                'other' => 'Other',
                                default => str($state)->headline()->toString(),
                            }),

                        TextEntry::make('created_at')
                            ->label('Reported at')
                            ->dateTime()
                            ->since(),

                        TextEntry::make('details')
                            ->label('Additional details')
                            ->placeholder('No additional details provided')
                            ->columnSpanFull(),
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Reported Comment
                |--------------------------------------------------------------------------
                */

                Section::make('Reported comment')
                    ->description('The article and comment associated with this report.')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextEntry::make('comment.article.title')
                            ->label('Article')
                            ->placeholder('Article unavailable')
                            ->columnSpanFull(),

                        TextEntry::make('comment.body')
                            ->label('Comment')
                            ->placeholder('Comment unavailable')
                            ->columnSpanFull()
                            ->prose(),
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Reporter Information
                |--------------------------------------------------------------------------
                */

                Section::make('Reporter information')
                    ->description('Details about the person who submitted this report.')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('reporter.display_name')
                            ->label('Registered user')
                            ->placeholder('Guest reporter')
                            ->visible(fn (CommentReport $record): bool => $record->user_id !== null),

                        TextEntry::make('first_name')
                            ->label('First name')
                            ->placeholder('—')
                            ->visible(fn (CommentReport $record): bool => $record->user_id === null),

                        TextEntry::make('last_name')
                            ->label('Last name')
                            ->placeholder('—')
                            ->visible(fn (CommentReport $record): bool => $record->user_id === null),

                        TextEntry::make('email')
                            ->label('Email address')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Review Information
                |--------------------------------------------------------------------------
                */

                Section::make('Review information')
                    ->description('Information about the moderation of this report.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('reviewer.display_name')
                            ->label('Reviewed by')
                            ->placeholder('Not reviewed yet'),

                        TextEntry::make('reviewed_at')
                            ->label('Last status change')
                            ->dateTime()
                            ->placeholder('—'),
                    ])
                    ->collapsed(),
            ]);
    }
}