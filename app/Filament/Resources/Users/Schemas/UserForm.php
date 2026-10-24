<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

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

                        Placeholder::make('flair')
                            ->label('Flair')
                            ->content(fn ($record): string => $record?->flair ?? '—'),

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

                Section::make('Community flair')
                    ->description('Give this user a special flair that appears next to their name in comments.')
                    ->schema([
                        TextInput::make('flair')
                            ->label('Flair')
                            ->placeholder('e.g. Shiny Hunter')
                            ->maxLength(50)
                            ->nullable()
                            ->helperText('Optional. Leave empty if this user has no flair.'),
                    ])
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
                            ->getOptionLabelFromRecordUsing(
                                fn ($record): string => ucfirst($record->name),
                            )
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

                Section::make('Activity history')
                    ->collapsed()
                    ->description('User activity from the last 90 days. Older records remain stored in the database.')
                    ->schema([
                        Placeholder::make('activity_history')
                            ->label('Recent activity')
                            ->content(function ($record): string|HtmlString {
                                if (! $record) {
                                    return 'No activity recorded yet.';
                                }

                                $activities = $record->loginActivities()
                                    ->where('created_at', '>=', now()->subDays(90))
                                    ->latest('created_at')
                                    ->limit(10)
                                    ->get();

                                if ($activities->isEmpty()) {
                                    return 'No activity recorded in the last 90 days.';
                                }

                                $items = $activities->map(function ($activity): string {
                                    $type = e($activity->activity_type);
                                    $date = e($activity->created_at?->format('Y-m-d H:i') ?? 'Unknown date');
                                    $ip = e($activity->ip_address ?: 'Unknown');
                                    $browser = e(trim(implode(' ', array_filter([
                                        $activity->browser,
                                        $activity->browser_version,
                                    ])) ?: 'Unknown'));
                                    $platform = e(trim(implode(' ', array_filter([
                                        $activity->platform,
                                        $activity->platform_version,
                                    ])) ?: 'Unknown'));
                                    $deviceType = e($activity->device_type ?: 'Unknown');
                                    $device = e($activity->device ?: 'Unknown');

                                    return <<<HTML
                                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <span class="font-semibold text-gray-950 dark:text-white">{$type}</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{$date}</span>
                                            </div>
                                            <dl class="mt-3 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">IP address</dt>
                                                    <dd class="mt-1 break-all text-gray-950 dark:text-white">{$ip}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">Browser</dt>
                                                    <dd class="mt-1 text-gray-950 dark:text-white">{$browser}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">Operating system</dt>
                                                    <dd class="mt-1 text-gray-950 dark:text-white">{$platform}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">Device</dt>
                                                    <dd class="mt-1 text-gray-950 dark:text-white">{$deviceType} — {$device}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                    HTML;
                                })->implode('');

                                return new HtmlString(
                                    '<div class="space-y-4">' . $items . '</div>'
                                );
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}