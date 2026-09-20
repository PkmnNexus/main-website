<?php

namespace App\Filament\Forms\Components\Media\Browser;

final readonly class AssetBrowserFilters
{
    public function __construct(
        public ?string $search = null,
        public ?int $folderId = null,
        public ?string $mimeType = null,
        public string $sort = 'updated_at',
        public string $direction = 'desc',
        public int $perPage = 24,
    ) {}
}