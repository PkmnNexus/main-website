<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\EditAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name')
                    ->label('Display name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(',')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('suspension_status')
                    ->label('Suspension')
                    ->state(fn ($record): string => $record->isSuspended() ? 'Suspended' : 'Not suspended')
                    ->badge()
                    ->color(fn ($record): string => $record->isSuspended() ? 'danger' : 'success'),

                TextColumn::make('last_login_at')
                    ->label('Last login')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never'),

                TextColumn::make('last_activity_at')
                    ->label('Last activity')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('No activity'),

                TextColumn::make('created_at')
                    ->label('Registered at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('email_verified_at')
                    ->label('Email verified')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('suspended_until')
                    ->label('Suspended until')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->multiple(),

                TernaryFilter::make('is_active')
                    ->label('Account status')
                    ->placeholder('All accounts')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),

                TernaryFilter::make('suspended')
                    ->label('Suspension status')
                    ->placeholder('All accounts')
                    ->trueLabel('Suspended')
                    ->falseLabel('Not suspended')
                    ->queries(
                        true: fn (Builder $query) => $query
                            ->whereNotNull('suspended_at')
                            ->where(function (Builder $query) {
                                $query
                                    ->whereNull('suspended_until')
                                    ->orWhere('suspended_until', '>=', now());
                            }),
                        false: fn (Builder $query) => $query
                            ->where(function (Builder $query) {
                                $query
                                    ->whereNull('suspended_at')
                                    ->orWhere('suspended_until', '<', now());
                            }),
                        blank: fn (Builder $query) => $query,
                    ),

                TernaryFilter::make('email_verified_at')
                    ->label('Email verification')
                    ->placeholder('All users')
                    ->trueLabel('Verified')
                    ->falseLabel('Not verified')
                    ->nullable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn ($record): bool => $record->id !== Auth::id()),
            ]);
    }
}