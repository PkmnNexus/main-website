<?php

return [

    'roles' => [

        'admin' => [
            '*' => ['*'],
        ],

        'editor' => [
            'category' => [
                'view_any',
                'view',
                'create',
                'update',
                'delete',
                'delete_any',
            ],
        ],

        'author' => [
            //
        ],

        'member' => [
            //
        ],

    ],

];