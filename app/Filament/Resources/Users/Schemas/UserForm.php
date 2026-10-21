<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile')
                    ->schema([
                        Placeholder::make('name')
                            ->label('Name')
                            ->content(fn ($record): string => $record?->name ?? '—'),

                        Placeholder::make('display_name')
                            ->label('Display name')
                            ->content(fn ($record): string => $record?->display_name ?? '—'),

                        Placeholder::make('slug')
                            ->label('Slug')
                            ->content(fn ($record): string => $record?->slug ?? '—'),

                        Placeholder::make('email')
                            ->label('Email address')
                            ->content(fn ($record): string => $record?->email ?? '—'),

                        Placeholder::make('email_verified_at')
                            ->label('Email verified at')
                            ->content(fn ($record): string => $record?->email_verified_at?->format('Y-m-d H:i') ?? 'Not verified'),

                        Placeholder::make('bio')
                            ->label('Bio')
                            ->content(fn ($record): string => $record?->bio ?: '—')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Roles & permissions')
                    ->schema([
                        Select::make('roles')
                            ->label('Roles')
                            ->relationship(
                                name: 'roles',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query
                                    ->where('guard_name', 'web')
                                    ->orderBy('name'),
                            )
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Assign the roles this user should have.'),
                    ])
                    ->columnSpanFull(),

                Section::make('Account status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->required(),

                        Placeholder::make('last_login_at')
                            ->label('Last login')
                            ->content(fn ($record): string => $record?->last_login_at?->format('Y-m-d H:i') ?? 'Never'),

                        Placeholder::make('last_activity_at')
                            ->label('Last activity')
                            ->content(fn ($record): string => $record?->last_activity_at?->format('Y-m-d H:i') ?? 'No activity'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Suspension')
                    ->schema([
                        DateTimePicker::make('suspended_at')
                            ->label('Suspended at'),

                        DateTimePicker::make('suspended_until')
                            ->label('Suspended until')
                            ->afterOrEqual('suspended_at'),

                        Textarea::make('suspended_reason')
                            ->label('Suspension reason')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}