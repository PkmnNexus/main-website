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
                Section::make(__('admin.profile'))
                    ->schema([
                        Placeholder::make('name')
                            ->label(__('admin.name'))
                            ->content(fn ($record): string => $record?->name ?? '—'),

                        Placeholder::make('display_name')
                            ->label(__('admin.display_name'))
                            ->content(fn ($record): string => $record?->display_name ?? '—'),

                        Placeholder::make('flair')
                            ->label(__('admin.flair'))
                            ->content(fn ($record): string => $record?->flair ?? '—'),

                        Placeholder::make('slug')
                            ->label(__('admin.slug'))
                            ->content(fn ($record): string => $record?->slug ?? '—'),

                        Placeholder::make('email')
                            ->label(__('admin.email_address'))
                            ->content(fn ($record): string => $record?->email ?? '—'),

                        Placeholder::make('email_verified_at')
                            ->label(__('admin.email_verified_at'))
                            ->content(fn ($record): string => $record?->email_verified_at?->format('Y-m-d H:i') ?? __('admin.not_verified')),

                        Placeholder::make('bio')
                            ->label(__('admin.bio'))
                            ->content(fn ($record): string => $record?->bio ?: '—')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('admin.community_flair'))
                    ->description(__('admin.community_flair_description'))
                    ->schema([
                        TextInput::make('flair')
                            ->label(__('admin.flair'))
                            ->placeholder(__('admin.flair_placeholder'))
                            ->maxLength(50)
                            ->nullable()
                            ->helperText(__('admin.flair_helper')),
                    ])
                    ->columnSpanFull(),

                Section::make(__('admin.roles_permissions'))
                    ->schema([
                        Select::make('roles')
                            ->label(__('admin.roles'))
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
                            ->helperText(__('admin.assign_user_roles')),
                    ])
                    ->columnSpanFull(),

                Section::make(__('admin.account_status'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('admin.active'))
                            ->required(),

                        Placeholder::make('last_login_at')
                            ->label(__('admin.last_login'))
                            ->content(fn ($record): string => $record?->last_login_at?->format('Y-m-d H:i') ?? __('admin.never')),

                        Placeholder::make('last_activity_at')
                            ->label(__('admin.last_activity'))
                            ->content(fn ($record): string => $record?->last_activity_at?->format('Y-m-d H:i') ?? __('admin.no_activity')),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('admin.suspension'))
                    ->schema([
                        DateTimePicker::make('suspended_at')
                            ->label(__('admin.suspended_at')),

                        DateTimePicker::make('suspended_until')
                            ->label(__('admin.suspended_until'))
                            ->afterOrEqual('suspended_at'),

                        Textarea::make('suspended_reason')
                            ->label(__('admin.suspension_reason'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('admin.activity_history'))
                    ->collapsed()
                    ->description(__('admin.activity_history_description'))
                    ->schema([
                        Placeholder::make('activity_history')
                            ->label(__('admin.recent_activity'))
                            ->content(function ($record): string|HtmlString {
                                if (! $record) {
                                    return __('admin.no_activity_recorded_yet');
                                }

                                $activities = $record->loginActivities()
                                    ->where('created_at', '>=', now()->subDays(90))
                                    ->latest('created_at')
                                    ->limit(10)
                                    ->get();

                                if ($activities->isEmpty()) {
                                    return __('admin.no_activity_last_90_days');
                                }

                                $items = $activities->map(function ($activity): string {
                                    $type = e($activity->activity_type);
                                    $date = e($activity->created_at?->format('Y-m-d H:i') ?? __('admin.unknown_date'));
                                    $ip = e($activity->ip_address ?: __('admin.unknown'));
                                    $browser = e(trim(implode(' ', array_filter([
                                        $activity->browser,
                                        $activity->browser_version,
                                    ])) ?: __('admin.unknown')));
                                    $platform = e(trim(implode(' ', array_filter([
                                        $activity->platform,
                                        $activity->platform_version,
                                    ])) ?: __('admin.unknown')));
                                    $deviceType = e($activity->device_type ?: __('admin.unknown'));
                                    $device = e($activity->device ?: __('admin.unknown'));

                                    $ipAddressLabel = e(__('admin.ip_address'));
                                    $browserLabel = e(__('admin.browser'));
                                    $operatingSystemLabel = e(__('admin.operating_system'));
                                    $deviceLabel = e(__('admin.device'));

                                    return <<<HTML
                                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <span class="font-semibold text-gray-950 dark:text-white">{$type}</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{$date}</span>
                                            </div>
                                            <dl class="mt-3 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">{$ipAddressLabel}</dt>
                                                    <dd class="mt-1 break-all text-gray-950 dark:text-white">{$ip}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">{$browserLabel}</dt>
                                                    <dd class="mt-1 text-gray-950 dark:text-white">{$browser}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">{$operatingSystemLabel}</dt>
                                                    <dd class="mt-1 text-gray-950 dark:text-white">{$platform}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-gray-500 dark:text-gray-400">{$deviceLabel}</dt>
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