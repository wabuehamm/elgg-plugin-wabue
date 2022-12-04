<?php

use Wabue\Membership\Entities\ParticipationObject;
use Wabue\Membership\Entities\Season;
use Wabue\Membership\Tools;

$errors = get_input('errors','');

if (!empty($errors)) {
    echo elgg_view_module('error', elgg_echo('wabue:appointment:import:error'), $errors);
}

echo elgg_view_field([
    '#type' => 'file',
    '#label' => elgg_echo('wabue:appointment:import:file:label'),
    '#help' => elgg_echo('wabue:appointment:import:file:help'),
    'name' => 'import',
    'required' => true,
]);

elgg_set_form_footer(
    elgg_view_field([
        '#type' => 'submit',
        'text' => elgg_echo("wabue:appointment:import:submit"),
    ])
);
