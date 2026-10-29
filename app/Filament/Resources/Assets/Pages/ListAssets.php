<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssets extends ListRecords
{
    protected static string $resource = AssetResource::class;

    public function getTitle(): string
    {
        return __('admin.assets');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label(__('admin.create_asset')),
        ];
    }
}
