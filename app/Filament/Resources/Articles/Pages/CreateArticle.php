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

    public function getTitle(): string
    {
        return __('admin.article');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if ($user->hasRole('author') && ! $user->hasAnyRole(['admin', 'editor'])) {
            $data['user_id'] = $user->id;
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
                    ->title(__('admin.youtube_metadata_not_found'))
                    ->body(__('admin.article_saved_video_metadata_unavailable'))
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
                ->title(__('admin.youtube_metadata_retrieval_failed'))
                ->body(__('admin.article_saved_retry_metadata_later'))
                ->warning()
                ->send();
        }
    }
}