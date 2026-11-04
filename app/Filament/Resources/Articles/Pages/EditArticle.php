<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\ArticleResource;
use App\Models\Tag;
use App\Services\YouTubeService;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Throwable;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected ?string $originalVideoUrl = null;

    protected array $pendingTags = [];

    public function getTitle(): string
    {
        return __('admin.article');
    }

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
                __('admin.can_only_edit_own_articles'),
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (! config('localization.enabled', false)) {
            $defaultLocale = config('localization.default', 'en');

            foreach ([
                'title',
                'slug',
                'excerpt',
                'summary',
                'content',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'canonical',
                'og_title',
                'og_description',
            ] as $field) {
                $data[$field] = $this->record->getTranslation(
                    $field,
                    $defaultLocale,
                    false,
                );
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remember the original URL before the record is updated.
        $this->originalVideoUrl = $this->record->video_url;

        if (! config('localization.enabled', false)) {
            $defaultLocale = config('localization.default', 'en');

            foreach ([
                'title',
                'slug',
                'excerpt',
                'summary',
                'content',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'canonical',
                'og_title',
                'og_description',
            ] as $field) {
                $data[$field] = [
                    $defaultLocale => $data[$field] ?? null,
                ];
            }
        }

        $user = auth()->user();

        if ($user->hasRole('author') && ! $user->hasAnyRole(['admin', 'editor'])) {
            $data['user_id'] = $user->id;
            $data['status'] = $this->record->status instanceof ArticleStatus
                ? $this->record->status->value
                : $this->record->status;
        }

        $this->pendingTags = $this->normalizePendingTags($data['tags'] ?? []);

        unset($data['tags']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncArticleTags();

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

    protected function normalizePendingTags(mixed $tags): array
    {
        $localizationEnabled = (bool) config('localization.enabled', false);

        if (! is_array($tags)) {
            $tags = $localizationEnabled
                ? [config('localization.default', 'en') => $tags]
                : [$tags];
        }

        $normalizeNames = function (mixed $names): array {
            $names = is_array($names) ? $names : [$names];

            return collect($names)
                ->flatMap(function ($name): array {
                    if (! is_string($name) || trim($name) === '') {
                        return [];
                    }

                    return preg_split('/\s*,\s*/u', trim($name), -1, PREG_SPLIT_NO_EMPTY) ?: [];
                })
                ->map(fn (string $name): string => trim($name))
                ->filter()
                ->unique()
                ->values()
                ->all();
        };

        if ($localizationEnabled) {
            return collect($tags)
                ->mapWithKeys(fn ($names, $locale) => [
                    $locale => $normalizeNames($names),
                ])
                ->all();
        }

        return $normalizeNames($tags);
    }

    protected function syncArticleTags(): void
    {
        $defaultLocale = config('localization.default', 'en');
        $localizationEnabled = (bool) config('localization.enabled', false);

        $tagNamesByLocale = $localizationEnabled
            ? collect($this->pendingTags)
            : collect([$defaultLocale => $this->pendingTags]);

        $tagCount = $tagNamesByLocale->max(
            fn ($names) => count((array) $names),
        ) ?? 0;

        $tags = collect(range(0, max(0, $tagCount - 1)))
            ->map(function (int $index) use ($tagNamesByLocale, $defaultLocale) {
                $translations = $tagNamesByLocale
                    ->mapWithKeys(fn ($names, $locale) => [
                        $locale => trim((string) ($names[$index] ?? '')),
                    ])
                    ->filter(fn (string $name) => $name !== '');

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
                        $translations->get($defaultLocale) ?? $translations->first(),
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