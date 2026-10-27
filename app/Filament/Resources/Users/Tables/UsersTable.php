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
                    ->label(__('admin.display_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('admin.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label(__('admin.email_address'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label(__('admin.roles'))
                    ->badge()
                    ->separator(',')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('admin.active'))
                    ->boolean()
                    ->sortable(),

                TextColumn::make('suspension_status')
                    ->label(__('admin.suspension'))
                    ->state(fn ($record): string => $record->isSuspended()
                        ? __('admin.suspended')
                        : __('admin.not_suspended'))
                    ->badge()
                    ->color(fn ($record): string => $record->isSuspended() ? 'danger' : 'success'),

                TextColumn::make('last_login_at')
                    ->label(__('admin.last_login'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder(__('admin.never')),

                TextColumn::make('last_activity_at')
                    ->label(__('admin.last_activity'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder(__('admin.no_activity')),

                TextColumn::make('created_at')
                    ->label(__('admin.registered_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('email_verified_at')
                    ->label(__('admin.email_verified'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('suspended_until')
                    ->label(__('admin.suspended_until'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('admin.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label(__('admin.role'))
                    ->relationship('roles', 'name')
                    ->multiple(),

                TernaryFilter::make('is_active')
                    ->label(__('admin.account_status'))
                    ->placeholder(__('admin.all_accounts'))
                    ->trueLabel(__('admin.active'))
                    ->falseLabel(__('admin.inactive')),

                TernaryFilter::make('suspended')
                    ->label(__('admin.suspension_status'))
                    ->placeholder(__('admin.all_accounts'))
                    ->trueLabel(__('admin.suspended'))
                    ->falseLabel(__('admin.not_suspended'))
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
                    ->label(__('admin.email_verification'))
                    ->placeholder(__('admin.all_users'))
                    ->trueLabel(__('admin.verified'))
                    ->falseLabel(__('admin.not_verified'))
                    ->nullable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn ($record): bool => $record->id !== Auth::id()),
            ]);
    }
}