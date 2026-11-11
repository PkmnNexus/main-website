<?php

return [

    'roles' => [

        'super_admin' => [
            '*' => ['*'],
        ],

        'admin' => [
            '*' => ['*'],

            'except' => [
                'User',
                'Role',
            ],
        ],

        'editor' => [
            'Article' => ['*'],
            'Category' => ['*'],
            'Trivia' => ['*'],
            'Poll' => ['*'],
            'Comment' => ['*'],
            'CommentReport' => ['*'],

            'widgets' => [
                'View:Dashboard',
                'View:CommentReportsOverview',
                'View:ContentCommunityOverview',
                'View:EditorialPlanning',
            ],
        ],

        'author' => [
            'Article' => ['*'],
            'Category' => ['*'],
            'Trivia' => ['*'],
            'Poll' => ['*'],

            'widgets' => [
                'View:Dashboard',
            ],
        ],

        'member' => [],

    ],

];