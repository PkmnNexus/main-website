<?php

namespace App\Filament\Resources\Comments\Pages;

use App\Filament\Resources\Comments\CommentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditComment extends EditRecord
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static string $resource = CommentResource::class;

    /*
    |--------------------------------------------------------------------------
    | Header Actions
    |--------------------------------------------------------------------------
    */

    /**
     * Provide moderation actions for the current comment.
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),

            RestoreAction::make(),
        ];
    }
}