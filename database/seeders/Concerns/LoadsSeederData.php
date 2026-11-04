<?php

namespace Database\Seeders\Concerns;

use RuntimeException;

trait LoadsSeederData
{
    protected function loadSeederData(
        string $file,
        array $translatableFields = [],
    ): array {
        $locales = config('localization.enabled', false)
            ? array_keys(config('localization.locales', []))
            : [config('localization.default', 'en')];

        $data = [];

        foreach ($locales as $locale) {
            $path = database_path("seeders/Data/{$locale}/{$file}.php");

            if (! file_exists($path)) {
                throw new RuntimeException(
                    "Seeder data file not found: {$path}"
                );
            }

            $localeData = require $path;

            foreach ($localeData as $item) {
                $key = $item['key'];

                if (! isset($data[$key])) {
                    $data[$key] = [
                        'key' => $key,
                    ];
                }

                foreach ($item as $field => $value) {
                    if (in_array($field, $translatableFields, true)) {
                        $data[$key][$field][$locale] = $value;

                        continue;
                    }

                    $data[$key][$field] = $value;
                }
            }
        }

        return array_values($data);
    }
}