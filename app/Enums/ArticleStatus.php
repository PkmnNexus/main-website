<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ArticleStatus: string implements HasLabel, HasColor, HasIcon
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Published = 'published';
    case Archived = 'archived';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => __('admin.draft'),
            self::Pending => __('admin.pending_review'),
            self::Published => __('admin.published'),
            self::Archived => __('admin.archived'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Pending => 'warning',
            self::Published => 'success',
            self::Archived => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'heroicon-o-pencil-square',
            self::Pending => 'heroicon-o-clock',
            self::Published => 'heroicon-o-check-circle',
            self::Archived => 'heroicon-o-archive-box',
        };
    }
}