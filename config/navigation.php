<?php

return [
    'main' => [
        [
            'label' => 'Home',
            'route' => 'home',
            'active_routes' => [
                'home',
            ],
        ],
        [
            'label' => 'Articles',
            'route' => 'article.index',
            'active_routes' => [
                'article.*',
                'category.*',
                'tag.*',
            ],
        ],
    ],
    'subfooter' => [
        [
            'label' => 'About',
            'route' => 'home'
        ],
        [
            'label' => 'FAQ',
            'route' => 'home'
        ],
        [
            'label' => 'Terms and Conditions',
            'route' => 'home'
        ]
    ],
    'categories' => [
        [
            'label' => 'Pokémon TCG',
            'route' => 'home'
        ],
        [
            'label' => 'Pokémon GO',
            'route' => 'home'
        ],
        [
            'label' => 'Pokémon Horizons',
            'route' => 'home'
        ],
        [
            'label' => 'Pokémon Legends: Z-A',
            'route' => 'home'
        ],
        [
            'label' => 'Nintendo Switch',
            'route' => 'home'
        ]
    ],
    'footer' => [
        [
            'label' => 'Disclaimer',
            'route' => 'home'
        ],
        [
            'label' => 'Cookie Policy',
            'route' => 'home'
        ],
        [
            'label' => 'Sitemap',
            'route' => 'home'
        ]
    ]
];
