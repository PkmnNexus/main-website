<?php

namespace App\Filament\Resources\Trivias\Pages;

use App\Filament\Resources\Trivias\TriviaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrivia extends CreateRecord
{
    protected static string $resource = TriviaResource::class;

    public function getTitle(): string
    {
        return __('admin.create_trivia');
    }
}