<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\ArticleResource;
use App\Models\Tag;
use App\Services\YouTubeService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Throwable;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected array $pendingTags = [];

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

        $this->pendingTags = $data['tags'] ?? [];

        unset($data['tags']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->syncArticleTags();

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

    protected function syncArticleTags(): void
    {
        $tags = collect($this->pendingTags)
            ->map(function (array $translations) {
                $translations = collect($translations)
                    ->map(fn ($name) => trim((string) $name))
                    ->filter();

                if ($translations->isEmpty()) {
                    return null;
                }

                $tag = Tag::query()
                    ->where(function ($query) use ($translations) {
                        foreach ($translations as $locale => $name) {
                            $query->orWhere("name->{$locale}", $name);
                        }
                    })
                    ->first();

                if (! $tag) {
                    $tag = new Tag();
                    $tag->slug = Str::slug(
                        $translations->get('en') ?? $translations->first(),
                    );
                }

                foreach ($translations as $locale => $name) {
                    $tag->setTranslation('name', $locale, $name);
                }

                $tag->save();

                return $tag;
            })
            ->filter()
            ->unique('id')
            ->values();

        $this->record->syncTags($tags);
    }
}