<?php

use Wabue\Core\Bootstrap;

$testmode = elgg_get_plugin_setting('testmode', 'wabue', 'off');

$helpsuffix = '';
$settingEnabled = true;
if (!Bootstrap::testmodeValid()) {
    $helpsuffix = elgg_echo('wabue:settings:testmode:disabled');
    $settingEnabled = false;
}

$params = [
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
    $params['disabled'] = 'disabled';
}

echo elgg_view_field($params);

