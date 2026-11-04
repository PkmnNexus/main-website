<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('admin.page');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
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
                $data[$field] = $this->record->getTranslation(
                    $field,
                    $defaultLocale,
                    false,
                );
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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