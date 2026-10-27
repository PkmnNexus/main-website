<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommentForm
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the comment form.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('body')
                    ->label(__('admin.comment'))
                    ->required()
                    ->string()
                    ->minLength(2)
                    ->maxLength(2000)
                    ->rows(10)
                    ->columnSpanFull(),
            ]);
    }
}