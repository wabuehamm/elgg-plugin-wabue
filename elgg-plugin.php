<?php

# Fix to include images uploaded using hypeEmbed originally

use Elgg\Router\Middleware\Gatekeeper;
use Wabue\Core\AppointmentGatekeeper;

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
        'view:uploadappointments' => [
            'path' => '/wabue/appointments',
            'resource' => 'wabue/appointments',
            'middleware' => [
                Gatekeeper::class,
                AppointmentGatekeeper::class
            ]
        ],
    ],
    'settings' => [
        'appointment_users' => ''
    ],
    'actions' => [
        'wabue/appointment/import' => [
            'access' => 'logged_in'
        ]
    ]
];
