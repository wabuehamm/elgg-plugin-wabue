<?php

/**
 * Overridden agenda view to use a better date format
 */

$nav = elgg_view('navigation/pagination',[
	'base_url' => $_SERVER['SCRIPT_NAME'].'/?'.$_SERVER['QUERY_STRING'],
	'offset' => $vars['offset'],
	'count' => $vars['count'],
	'limit' => $vars['limit'],
]);

$event_calendar_times = elgg_get_plugin_setting('times', 'event_calendar');
$events = $vars['events'];
$html = '';
$date_format_day = 'j';
$date_format_month = 'm';
$date_format_year = 'Y';
$current_date = '';

setlocale(LC_TIME, "de_DE.utf8");

if ($events) {
	foreach($events as $event) {
		$date = strftime('%A, %d.%m.%Y', $event->start_date);
		if ($date != $current_date) {
			if ($html) {
				$html .= elgg_view('event_calendar/agenda_footer');
			}
			$html .= elgg_view('event_calendar/agenda_header', ['date' => $date]);

			$current_date = $date;
		}
		$html .= elgg_view('event_calendar/agenda_item_view', ['event' => $event, 'times' => $event_calendar_times]);
	}
	$html .= elgg_view('event_calendar/agenda_footer');
}
$html = $nav.'<div class="event_calendar_agenda">'.$html.'</div>'.$nav;

echo $html;
