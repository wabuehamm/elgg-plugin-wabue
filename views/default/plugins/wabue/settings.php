<?php

use Wabue\Core\Bootstrap;

$testmode = elgg_get_plugin_setting('testmode', 'wabue', 'off');

$helpsuffix = '';
$settingEnabled = true;
if (!Bootstrap::testmodeValid()) {
    $helpsuffix = elgg_echo('wabue:settings:testmode:disabled');
    $settingEnabled = false;
}

$testmodefield = [
    '#type' => 'select',
    '#label' => elgg_echo('wabue:settings:testmode:label'),
    '#help' => elgg_echo('wabue:settings:testmode:help') . ' ' . $helpsuffix,
    'name' => 'params[testmode]',
    'value' => $testmode,
    'options_values' => [
        [
            'value' => 'on',
            'text' => elgg_echo('on')
        ],
        [
            'value' => 'off',
            'text' => elgg_echo('off')
        ]
    ]
];
if (!$settingEnabled) {
    $testmodefield['disabled'] = 'disabled';
}

echo elgg_view_field($testmodefield);

$appointment_users = elgg_get_plugin_setting('appointment_users', 'wabue');

$appointment_users_field = [
    '#type' => 'longtext',
    '#label' => elgg_echo('wabue:settings:appointmentusers:label'),
    '#help' => elgg_echo('wabue:settings:appointmentusers:help'),
    'editor' => false,
    'name' => 'params[appointment_users]',
    'value' => $appointment_users
];

echo elgg_view_field($appointment_users_field);
