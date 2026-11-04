<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('admin.page');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! config('localization.enabled', false)) {
            $defaultLocale = config('localization.default', 'en');

            foreach ([
                'slug',
                'content',
                'title',
                'meta_description',
                'meta_keywords',
                'canonical',
                'og_title',
                'og_description',
            ] as $field) {
                if (array_key_exists($field, $data)) {
                    $data[$field] = [
                        $defaultLocale => $data[$field],
                    ];
                }
            }
        }

        return $data;
    }
}