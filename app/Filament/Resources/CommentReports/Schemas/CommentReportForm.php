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
                    ->label(__('admin.reported_comment'))
                    ->relationship('comment', 'id')
                    ->required(),

                TextInput::make('user_id')
                    ->label(__('admin.user'))
                    ->numeric(),

                TextInput::make('first_name')
                    ->label(__('admin.first_name')),

                TextInput::make('last_name')
                    ->label(__('admin.last_name')),

                TextInput::make('email')
                    ->label(__('admin.email_address'))
                    ->email(),

                TextInput::make('reason')
                    ->label(__('admin.reason'))
                    ->required(),

                Textarea::make('details')
                    ->label(__('admin.details'))
                    ->columnSpanFull(),

                TextInput::make('status')
                    ->label(__('admin.status'))
                    ->required()
                    ->default('pending'),

                TextInput::make('reviewed_by')
                    ->label(__('admin.reviewed_by'))
                    ->numeric(),

                DateTimePicker::make('reviewed_at')
                    ->label(__('admin.reviewed_at')),
            ]);
    }
}