<?php

return [
    'locales' => [
        'en' => [
            'label' => 'English',
            'name' => 'English',
            'flag' => 'us',
            'format' => 'en_US',
        ],

        'nl' => [
            'label' => 'Nederlands',
            'name' => 'Dutch',
            'flag' => 'nl',
            'format' => 'nl_NL',
        ],
    ],

    'default' => env('APP_DEFAULT_LANGUAGE', 'en'),

    'enabled' => env('APP_LOCALIZATION_ENABLED', false),

    'routes' => [
        'en' => [
            'articles' => 'articles',
            'category' => 'category',
            'tag' => 'tag',
            'author' => 'author',
            'video' => 'video',

            'auth' => [
                'login' => 'login',
                'register' => 'register',
                'forgot-password' => 'forgot-password',
                'reset-password' => 'reset-password',
                'email-verification' => 'email/verify',
                'two-factor-challenge' => 'two-factor-challenge',
                'confirm-password' => 'user/confirm-password',
                'passkey-login' => 'passkeys/login',
            ],

            'account' => [
                'profile' => 'account/profile',
                'edit-profile' => 'account/profile/edit',
            ],
        ],

        'nl' => [
            'articles' => 'artikelen',
            'category' => 'categorie',
            'tag' => 'tag',
            'author' => 'auteur',
            'video' => 'video',

            'auth' => [
                'login' => 'inloggen',
                'register' => 'registreren',
                'forgot-password' => 'wachtwoord-vergeten',
                'reset-password' => 'wachtwoord-herstellen',
                'email-verification' => 'email/verifieren',
                'two-factor-challenge' => 'twee-factor-controle',
                'confirm-password' => 'wachtwoord-bevestigen',
                'passkey-login' => 'passkeys/inloggen',
            ],

            'account' => [
                'profile' => 'account/profiel',
                'edit-profile' => 'account/profiel/bewerken',
            ],
        ],
    ],
];