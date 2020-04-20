<?php

$testmode = elgg_get_plugin_setting('testmode', 'wabue', 'off');

echo elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('wabue:settings:testmode:label'),
    '#help' => elgg_echo('wabue:settings:testmode:help'),
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
]);

