<?php

return [
    'locales' => [
        'en' => [
            'label' => 'English',
            'name' => 'English',
            'flag' => 'gb',
        ],

        'nl' => [
            'label' => 'Nederlands',
            'name' => 'Dutch',
            'flag' => 'nl',
        ],
    ],

    'default' => env('APP_DEFAULT_LANGUAGE', 'en'),

    'enabled' => env('APP_LOCALIZATION_ENABLED', false),
];