<?php

namespace App\Filament\Resources\Trivias\Pages;

use App\Filament\Resources\Trivias\TriviaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrivia extends EditRecord
{
    protected static string $resource = TriviaResource::class;

    public function getTitle(): string
    {
        return __('admin.edit_trivia');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}