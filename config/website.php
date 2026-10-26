<?php

return [
    'under_construction' => env('UNDER_CONSTRUCTION', true),

    'whitelist' => [
        // Localhost
        '127.0.0.1',
        '::1',

        // Michiel Home Torhout
        '141.135.250.160',
        '2a02:1811:a42a:fd00::/64',

        // Maarten Home Torhout
        '178.118.8.31',
        '2a02:1811:a430:a800::/64',

        // Sebastiaan Home Sas van Gent
        '145.53.107.21',
        '2a02:a455:a10b:ea60::/64',
    ],

    'features' => [
        'member_login' => env('FEATURE_MEMBER_LOGIN', false),
        'registration' => env('FEATURE_REGISTRATION', false),
        'comment' => env('FEATURE_COMMENTS', false),
    ]
];
