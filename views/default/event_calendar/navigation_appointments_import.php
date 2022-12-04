<?php

$user = elgg_get_logged_in_user_entity();
$appointment_users = preg_split("/\r?\n/", elgg_get_plugin_setting('appointment_users', 'wabue'));
if (in_array($user->username, $appointment_users)) {
    elgg_register_menu_item('title', [
        'name' => 'import_excel',
        'href' => elgg_generate_url(
            'view:uploadappointments'
        ),
        'icon' => 'file-excel',
        'text' => elgg_echo('wabue:appointment:import'),
        'link_class' => 'elgg-button elgg-button-action event-calendar-button-add',
    ]);
}
