<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return __('admin.categories');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label(__('admin.create_category')),
        ];
    }
}
