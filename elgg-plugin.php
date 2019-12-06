<?php

# Fix to include images uploaded using hypeEmbed originally

return [
    'bootstrap' => Wabue\Core\Bootstrap::class,
    'entities' => [
        [
            'type' => 'object',
            'subtype' => 'embed_file',
            'class' => \ElggFile::class
        ]
    ],
    'hooks' => [
        'commands' => [
            'cli' => [
                '\Wabue\Core\Commands::registerCommands' => []
            ]
        ]
    ],
    'routes' => [
        'wabue:membercard' => [
            'path' => '/wabue/membercard',
            'resource' => 'wabue/membercard',
        ],
    ],
];
