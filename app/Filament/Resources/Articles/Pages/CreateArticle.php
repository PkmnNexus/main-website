<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

use App\Enums\ArticleStatus;

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
}
