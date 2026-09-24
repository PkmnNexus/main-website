<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

use App\Enums\ArticleStatus;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (auth()->user()->hasRole('author')) {
            $data['user_id'] = auth()->id();
            $data['status'] = ArticleStatus::Pending->value;
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
}