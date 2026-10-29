
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
            'page_key' => 'about',
        ],
        [
            'label' => 'navigation.disclaimer',
            'route' => 'page.disclaimer',
            'page_key' => 'disclaimer',
        ],
        [
            'label' => 'navigation.privacy_policy',
            'route' => 'page.privacy-policy',
            'page_key' => 'privacy-policy',
        ],
        [
            'label' => 'navigation.terms_and_conditions',
            'route' => 'page.terms-and-conditions',
            'page_key' => 'terms-and-conditions',
        ],
        [
            'label' => 'navigation.cookie_policy',
            'route' => 'page.cookie-policy',
            'page_key' => 'cookie-policy',
        ],
    ],

    'categories' => [
        [
            'label' => 'navigation.pokemon_tcg',
            'route' => 'articles.category',
            'category_key' => 'pokemon-tcg',
        ],
        [
            'label' => 'navigation.pokemon_go',
            'route' => 'articles.category',
            'category_key' => 'pokemon-go',
        ],
    ],

    'footer' => [
        [
            'label' => 'navigation.disclaimer',
            'route' => 'page.disclaimer',
            'page_key' => 'disclaimer',
        ],
        [
            'label' => 'navigation.cookie_policy',
            'route' => 'page.cookie-policy',
            'page_key' => 'cookie-policy',
        ],
        [
            'label' => 'navigation.sitemap',
            'route' => 'sitemap',
        ],
    ],
];
