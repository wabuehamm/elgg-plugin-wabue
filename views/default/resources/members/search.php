<?php

# Overridden until https://github.com/Elgg/Elgg/issues/12172 gets resolved

/**
 * Members search page
 *
 */

$query = get_input("member_query");

if (empty($query)) {
    forward("members");
}

$limit = get_input('limit', elgg_get_config('default_limit'));
$offset = (int)get_input('offset', 0);

$display_query = _elgg_get_display_query($query);
$title = elgg_echo('members:title:search', array($display_query));

$options = array();
$options['query'] = $query;
$options['type'] = "user";
$options['offset'] = $offset;
$options['limit'] = $limit;
$options['order_by'] = 'ue.name';

$results = elgg_trigger_plugin_hook('search', 'user', $options, array());
$count = $results['count'];
$users = $results['entities'];

if (!empty($users)) {
    $content = elgg_view_entity_list($users, array(
        'count' => $count,
        'offset' => $offset,
        'limit' => $limit,
        'full_view' => false,
        'list_type_toggle' => false,
        'pagination' => true,
    ));
} else {
    $content = elgg_echo("notfound");
}

$params = array(
    'title' => $title,
    'content' => $content,
    'sidebar' => elgg_view('members/sidebar'),
);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
