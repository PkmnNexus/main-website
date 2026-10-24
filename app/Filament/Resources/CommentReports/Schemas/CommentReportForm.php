<?php

namespace App\Filament\Resources\CommentReports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommentReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('comment_id')
                    ->relationship('comment', 'id')
                    ->required(),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('reason')
                    ->required(),
                Textarea::make('details')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('reviewed_by')
                    ->numeric(),
                DateTimePicker::make('reviewed_at'),
            ]);
    }
}
