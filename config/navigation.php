<?php

return [
    'main' => [
        [
            'label' => 'navigation.home',
            'route' => 'home',
            'active_routes' => [
                'home',
            ],
        ],
        [
            'label' => 'navigation.articles',
            'route' => 'article.index',
            'active_routes' => [
                'article.index',
                'articles.category',
                'articles.tag',
                'articles.author',
                'article.show',
            ],
        ],
        [
            'label' => 'navigation.videos',
            'route' => 'articles.videos',
            'active_routes' => [
                'articles.videos',
                'article.video',
            ],
        ],
    ],
    'subfooter' => [
        [
            'label' => 'navigation.about',
            'route' => 'page.about',
        ],
        [
            'label' => 'navigation.disclaimer',
            'route' => 'page.disclaimer',
        ],
        [
            'label' => 'navigation.privacy_policy',
            'route' => 'page.privacy-policy',
        ],
        [
            'label' => 'navigation.terms_and_conditions',
            'route' => 'page.terms-and-conditions',
        ],
        [
            'label' => 'navigation.cookie_policy',
            'route' => 'page.cookie-policy',
        ],
    ],
    'categories' => [
        [
            'label' => 'navigation.pokemon_tcg',
            'route' => 'home',
        ],
        [
            'label' => 'navigation.pokemon_go',
            'route' => 'home',
        ],
        [
            'label' => 'navigation.pokemon_horizons',
            'route' => 'home',
        ],
        [
            'label' => 'navigation.pokemon_legends_za',
            'route' => 'home',
        ],
        [
            'label' => 'navigation.nintendo_switch',
            'route' => 'home',
        ],
    ],
    'footer' => [
        [
            'label' => 'navigation.disclaimer',
            'route' => 'page.disclaimer',
        ],
        [
            'label' => 'navigation.cookie_policy',
            'route' => 'page.cookie-policy',
        ],
        [
            'label' => 'navigation.sitemap',
            'route' => 'sitemap',
        ],
    ],
];