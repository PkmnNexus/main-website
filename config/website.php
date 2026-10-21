<?php

return [
    'under_construction' => env('UNDER_CONSTRUCTION', true),

    'whitelist' => [
        // Localhost
        '127.0.0.1',
        '::1',

        // Michiel Home Torhout
        '141.135.250.160',
        '2a02:1811:a42a:fd00:5cc0:64ea:f915:590b',
    ],

    'features' => [
        'member_login' => env('FEATURE_MEMBER_LOGIN', false),
        'registration' => env('FEATURE_REGISTRATION', false),
        'author_profiles' => env('FEATURE_AUTHOR_PROFILES', false),
    ],
];
