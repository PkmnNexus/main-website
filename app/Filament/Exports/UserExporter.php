<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Str;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')
                ->label('Name'),
            ExportColumn::make('display_name')
                ->label('Display name'),
            ExportColumn::make('slug')
                ->label('Slug'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('roles.name')
                ->label('Roles')
                ->formatStateUsing(fn ($state, User $record): string => $record->roles->pluck('name')->implode(', ')),
            ExportColumn::make('is_active')
                ->label('Active'),
            ExportColumn::make('last_login_at')
                ->label('Last login at'),
            ExportColumn::make('last_activity_at')
                ->label('Last activity at'),
            ExportColumn::make('suspended_at')
                ->label('Suspended at'),
            ExportColumn::make('suspended_until')
                ->label('Suspended until'),
            ExportColumn::make('suspended_reason')
                ->label('Suspension reason'),
            ExportColumn::make('created_at')
                ->label('Registered at'),
            ExportColumn::make('updated_at')
                ->label('Updated at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user export has completed and ' . Str::of('row')->counted($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Str::of('row')->counted($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}