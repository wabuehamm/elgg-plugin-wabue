<?php

# Fix to include images uploaded using hypeEmbed originally

use Elgg\Router\Middleware\Gatekeeper;
use Wabue\Core\AnnouncementCommand;
use Wabue\Core\AppointmentGatekeeper;
use Wabue\Core\ConfigurePluginsCommand;
use Wabue\Core\PrioritizeCommand;
use Wabue\Core\TestModeCommand;

return [
    'bootstrap' => Wabue\Core\Bootstrap::class,
    'plugin' => [
        'dependencies' => [
            'site_announcements' => [],
        ]
    ],
    'cli_commands' => [
        ConfigurePluginsCommand::class,
        PrioritizeCommand::class,
        TestModeCommand::class,
        AnnouncementCommand::class,
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
    ],
    'view_extensions' => [
        // Register Wabue CSS modifications
        'elements/layout.css' => [
            'css/wabue.css' => []
        ],

        // Walled Garden CSS extensions
        'walled_garden.css' => [
            'walled_garden_title.css' => [
                'priority' => 450
            ]
        ],

        // Register E-Mail address to profile view
        'profile/details' => [
            'profile/email' => [
                'priority' => 999
            ]
        ],

        // Show extra fields automatically on useradd
        'form/useradd' => [
            'forms/useradd_profile_fix' => [
                'priority' => 999
            ]
        ],

        // Disable editing of special fields in profile
        'resources/profile/edit' => [
            'profile/edit' => [
                'priority' => 450
            ]
        ],
    ],
    'web_services' => [
        'wabue.users.add' => [
            'POST' => [
                'callback' => '\Wabue\Core\WebService::addUser',
                'description' => 'Add a new user to the site',
                'params' => [
                    'user' => [
                        'type' => 'string',
                        'required' => true,
                        'description' => 'User object as JSON string'
                    ]
                ],
                'require_user_auth' => true,
            ],
        ],
        'wabue.discussion.add' => [
            'POST' => [
                'callback' => '\Wabue\Core\WebService::addDiscussion',
                'description' => 'Add a new discussion to the site',
                'params' => [
                    'discussion' => [
                        'type' => 'string',
                        'required' => true,
                        'description' => 'Discussion object in json form'
                    ]
                ],
                'require_user_auth' => true,
            ]
        ]
    ]
];
