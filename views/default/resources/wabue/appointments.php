<?php

$body = elgg_view_layout(
    'default',
    [
        'title' => elgg_echo("wabue:appointment:import"),
        'content' => elgg_view_form('wabue/appointment/import', [], $vars),
        'sidebar' => false,
    ]
);

echo elgg_view_page(
    elgg_echo("wabue:appointment:import"),
    $body
);
