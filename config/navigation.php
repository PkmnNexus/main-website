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
                'articles.*',
            ],
        ],
    ],
    'subfooter' => [
        [
            'label' => 'About',
            'route' => 'page.about'
        ],
        [
            'label' => 'Disclaimer',
            'route' => 'page.disclaimer'
        ],
        [
            'label' => 'Privacy Policy',
            'route' => 'page.privacy-policy'
        ],
        [
            'label' => 'Terms and Conditions',
            'route' => 'page.terms-and-conditions'
        ],
        [
            'label' => 'Cookie Policy',
            'route' => 'page.cookie-policy'
        ],
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
            'route' => 'page.disclaimer'
        ],
        [
            'label' => 'Cookie Policy',
            'route' => 'page.cookie-policy'
        ],
        [
            'label' => 'Sitemap',
            'route' => 'home'
        ]
    ]
];
