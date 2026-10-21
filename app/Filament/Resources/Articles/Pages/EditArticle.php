<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\ArticleResource;
use App\Services\YouTubeService;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;
use Throwable;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected ?string $originalVideoUrl = null;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        $user = auth()->user();

        if (
            $user->hasRole('author')
            && ! $user->hasAnyRole(['admin', 'editor'])
        ) {
            abort_unless(
                $this->record->user_id === $user->id,
                403,
                'You can only edit your own articles.',
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => auth()->user()?->hasRole('admin') ?? false)
                ->authorize(fn (): bool => auth()->user()?->hasRole('admin') ?? false),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remember the original URL before the record is updated.
        $this->originalVideoUrl = $this->record->video_url;

        $user = auth()->user();

        if ($user->hasRole('author') && ! $user->hasAnyRole(['admin', 'editor'])) {
            $data['user_id'] = $user->id;
            $data['status'] = $this->record->status instanceof ArticleStatus
                ? $this->record->status->value
                : $this->record->status;
        }

        $tags = collect($data['tags'] ?? [])
            ->flatMap(function ($value) {
                return is_string($value)
                    ? str_getcsv($value)
                    : $value;
            })
            ->map(fn (string $name) => trim($name))
            ->filter()
            ->unique()
            ->map(function (string $name) {
                return Tag::firstOrCreate(
                    [
                        'name' => ['en' => $name],
                    ],
                    [
                        'slug' => Str::slug($name),
                    ],
                );
            });

        $this->record->syncTags($tags);

        unset($data['tags']);

        return $data;
    }

    protected function afterSave(): void
    {
        $videoUrl = $this->record->video_url;

        $urlChanged = $this->originalVideoUrl !== $videoUrl;

        $metadataMissing = blank($this->record->youtube_published_at)
            || blank($this->record->youtube_thumbnail_url)
            || blank($this->record->youtube_duration);

        // Nothing to do when the URL and metadata are unchanged.
        if (! $urlChanged && ! $metadataMissing) {
            return;
        }

        // Remove metadata belonging to the previous video.
        if ($urlChanged) {
            $this->record->forceFill([
                'youtube_published_at' => null,
                'youtube_thumbnail_url' => null,
                'youtube_duration' => null,
            ])->saveQuietly();
        }

        // The video URL was removed.
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