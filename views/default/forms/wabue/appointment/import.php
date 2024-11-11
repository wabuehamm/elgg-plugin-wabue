<?php

use Wabue\Membership\Entities\ParticipationObject;
use Wabue\Membership\Entities\Season;
use Wabue\Membership\Tools;

$errors = get_input('errors','');
$events_imported = get_input('events_imported', 0);

if (!empty($errors)) {
    echo elgg_view_message('error', $errors);
}

$file = new ElggFile();
$file->owner_guid = elgg_get_logged_in_user_guid();
$file->setFilename('template.xlsx');
$file->open("write");
$file->write(file_get_contents(elgg_get_plugins_path().'/wabue/assets/template.xlsx'));
$file->close();

echo elgg_view_message('help', elgg_echo('wabue:appointment:import:intro', [elgg_get_download_url($file, false, null)]));

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
