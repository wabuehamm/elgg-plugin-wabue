<?php

$application_fields = $vars['application_fields'];
$delimiter = $_REQUEST['delimiter'] ?: ";";
$newline = $_REQUEST['newline'] ?: "\n";
$play_filter = $_REQUEST['play'] ?: null;

$list = elgg_get_entities([
    'type' => 'object',
    'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
    'limit' => false
]);

$custom_fields = [];

foreach ($list as $custom_field) {
    $custom_fields[$custom_field->metadata_name] = $custom_field->getTitle();
}

$field_labels = [];
foreach ($application_fields as $field) {
    array_push($field_labels, $custom_fields[$field]);
}

echo join(
    $delimiter, 
    array_merge(
        [
            elgg_echo('wabue:play'), 
            elgg_echo('name')
        ], 
        $field_labels
    )
) . $newline;

$users = elgg_get_entities(['type' => 'user', 'limit' => 0]);

foreach ($users as $user) {
    $user_plays_application = [];
    foreach ($application_fields as $field) {
        if (!is_null($user->get($field))) {
            $user_applications = $user->get($field);
            
            if (is_string($user_applications)) {
                $user_applications = [$user_applications];
            }

            foreach ($user_applications as $play) {
                if (!is_null($play_filter) && $play != $play_filter) {
                    continue;
                }
                if (!array_key_exists($play, $user_plays_application)) {
                    $user_plays_application[$play] = [];
                }
                $user_plays_application[$play][$field] = true;
            }
        }
    }
    foreach ($user_plays_application as $play => $user_applications) {
        $applications = [$play, $user->name];
        foreach ($application_fields as $field) {
            if (array_key_exists($field, $user_applications)) {
                array_push($applications, elgg_echo('option:yes'));
            } else {
                array_push($applications, elgg_echo('option:no'));
            }
        }
        echo join($delimiter, $applications) . $newline;
    }
}
