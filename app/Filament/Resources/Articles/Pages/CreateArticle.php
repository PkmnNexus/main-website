<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\ArticleResource;
use App\Services\YouTubeService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Throwable;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->user()->hasRole('author')) {
            $data['user_id'] = auth()->id();
            $data['status'] = ArticleStatus::Pending->value;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $videoUrl = $this->record->video_url;

        if (blank($videoUrl)) {
            return;
        }

        try {
            $metadata = app(YouTubeService::class)
                ->fetchMetadata($videoUrl);

            if ($metadata === null) {
                Notification::make()
                    ->title('YouTube metadata not found')
                    ->body('The article was saved, but the video metadata could not be retrieved.')
                    ->warning()
                    ->send();

                return;
            }

            $this->record->forceFill([
                'youtube_published_at' => $metadata['published_at'],
                'youtube_thumbnail_url' => $metadata['thumbnail_url'],
                'youtube_duration' => $metadata['duration'],
            ])->saveQuietly();
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('YouTube metadata could not be retrieved')
                ->body('The article was saved successfully. You can try retrieving the video metadata again later.')
                ->warning()
                ->send();
        }
    }
}