<?php

use Wabue\Membership\Entities\ParticipationObject;
use Wabue\Membership\Entities\Season;
use Wabue\Membership\Tools;

$errors = get_input('errors','');
$events_imported = get_input('events_imported', 0);

if (!empty($errors)) {
    echo elgg_view_message('error', $errors);
}

echo elgg_view_field([
    '#type' => 'file',
    '#label' => elgg_echo('wabue:appointment:import:file:label'),
    '#help' => elgg_echo('wabue:appointment:import:file:help'),
    'name' => 'import',
    'required' => true,
]);

echo elgg_view_field([
    '#type' => 'checkbox',
    '#label' => elgg_echo('wabue:appointment:import:check:label'),
    '#help' => elgg_echo('wabue:appointment:import:check:help'),
    'name' => 'check',
    'value' => 'yes',
    'checked' => true,
    'switch' => true
]);

elgg_set_form_footer(
    elgg_view_field([
        '#type' => 'submit',
        'text' => elgg_echo("wabue:appointment:import:submit"),
    ])
);
