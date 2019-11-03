<?php

# Fix to include images uploaded using hypeEmbed originally

return [
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
                'add_cli_commands' => []
            ]
        ]
    ]
];
