<?php

namespace App\Filament\Resources\CommentReports\Pages;

use App\Filament\Resources\CommentReports\CommentReportResource;
use App\Filament\Resources\Comments\CommentResource;
use App\Models\CommentReport;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewCommentReport extends ViewRecord
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static string $resource = CommentReportResource::class;

    /*
    |--------------------------------------------------------------------------
    | Page Title
    |--------------------------------------------------------------------------
    */

    /**
     * Display the report identifier as the page title.
     */
    public function getTitle(): string
    {
        return 'Report #' . $this->getRecord()->getKey();
    }

    /*
    |--------------------------------------------------------------------------
    | Header Actions
    |--------------------------------------------------------------------------
    */

    /**
     * Provide navigation to the reported comment.
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewComment')
                ->label('View comment')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->url(fn (CommentReport $record): ?string => $record->comment
                    ? CommentResource::getUrl('edit', [
                        'record' => $record->comment_id,
                    ])
                    : null)
                ->visible(fn (CommentReport $record): bool => $record->comment !== null)
                ->openUrlInNewTab(),
        ];
    }
}