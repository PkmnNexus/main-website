<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('admin.pages');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label(__('admin.create_page')),
        ];
    }
}
