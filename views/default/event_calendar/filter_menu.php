<?php

// generate a list of filter tabs

$filter_context = $vars['filter'];
$url_start = "event_calendar/list/{$vars['start_date']}/{$vars['mode']}";

$tabs = [
	'all' => [
		'text' => elgg_echo('event_calendar:show_all'),
		'href' => "$url_start/all",
		'selected' => ($filter_context == 'all'),
		'priority' => 100,
	],
];

if (elgg_is_logged_in()) {
	$tabs['mine'] = [
		'text' => elgg_echo('event_calendar:show_mine'),
		'href' => "$url_start/mine",
		'selected' => ($filter_context == 'mine'),
		'priority' => 200,
	];
	$tabs['friend'] = [
		'text' => elgg_echo('event_calendar:show_friends'),
		'href' => "$url_start/friends",
		'selected' => ($filter_context == 'friends'),
		'priority' => 300,
	];
}

$tab_rendered = [];

$event_calendar_spots_display = elgg_get_plugin_setting('spots_display', 'event_calendar');
if ($event_calendar_spots_display == "yes") {
	$tabs['open'] = [
		'text' => elgg_echo('event_calendar:show_open'),
		'href' => "$url_start/open",
		'selected' => ($filter_context == 'open'),
		'priority' => 400,
	];
} else {
	$tab_rendered['open'] = '';
}

foreach ($tabs as $name => $tab) {
	if ($tab['selected']) {
		$state_selected = ' is-active';
	} else {
		$state_selected = '';
	}
	$tab_rendered[$name] = '<a href="' . elgg_normalize_url($tab['href']) . '" class="elgg-anchor elgg-menu-content ' . $state_selected . ' nav-item is-tab"><span class="elgg-anchor-label">' . $tab['text'] . '</span></a>';
}

$menu = <<<__MENU
	{$tab_rendered['all']}
	{$tab_rendered['mine']}
	{$tab_rendered['friend']}
	{$tab_rendered['open']}
__MENU;

echo $menu;

$event_calendar_region_display = elgg_get_plugin_setting('region_display', 'event_calendar');
if ($event_calendar_region_display == 'yes') {
	elgg_require_js('event_calendar/event_calendar');
	$url_start .= "/$filter_context";
	echo elgg_view('event_calendar/region_select', ['url_start' => $url_start, 'region' => $vars['region']]);
}
