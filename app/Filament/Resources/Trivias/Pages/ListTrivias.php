<?php

namespace App\Filament\Resources\Trivias\Pages;

use App\Filament\Resources\Trivias\TriviaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrivias extends ListRecords
{
    protected static string $resource = TriviaResource::class;

    public function getTitle(): string
    {
        return __('admin.trivia');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('admin.create_trivia')),
        ];
    }
}