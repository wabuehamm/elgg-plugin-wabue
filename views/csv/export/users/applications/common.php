<?php

$common_field_name = 'common';
$delimiter = $_REQUEST['delimiter'] ?: ";";
$newline = $_REQUEST['newline'] ?: "\n";
$unit_filter = $_REQUEST['unit'] ?: null;

$applications = elgg_get_entities_from_metadata([
    "metadata_name_value_pairs" => [
        "name" => "metadata_name",
        "value" => $common_field_name
    ]
])[0]->getOptions();

echo join(
    $delimiter, 
    array_merge(
        [
            elgg_echo('name')
        ], 
        $applications
    )
) . $newline;

$users = elgg_get_entities(['type' => 'user', 'limit' => 0]);

foreach ($users as $user) {
    $user_applications = $user->get('common');
    $application_line = [$user->name];
    $yes_encountered = false;
    foreach ($applications as $application) {
        if (in_array($application, $user_applications)) {
            array_push($application_line, elgg_echo('option:yes'));
            $yes_encountered = true;
        } else {
            array_push($application_line, elgg_echo('option:no'));
        }
    }
    if ($yes_encountered) {
        echo join($delimiter, $application_line) . $newline;
    }
}
