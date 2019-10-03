<?php

$event_calendar_region_display = elgg_get_plugin_setting('region_display', 'event_calendar');
if ($event_calendar_region_display == 'yes') {
	elgg_require_js('event_calendar/event_calendar');
	$url_start .= "/$filter_context";
	echo elgg_view('event_calendar/region_select', ['url_start' => $url_start, 'region' => $vars['region']]);
}