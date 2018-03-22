<?php
function wabue_init() {
	// Register HypeUI CSS fixes
	elgg_extend_view('elements/layout.css', 'css/hypefixes');
	elgg_extend_view('elements/layout.css', 'css/wabue');
	elgg_extend_view('resources/event_calendar/edit', 'event_calendar/edit', 450);

	// Register E-Mail address to profile view
	elgg_extend_view('profile/details', 'profile/email');

    elgg_extend_view('event_calendar/agenda_view', 'event_calendar/agenda_view_fix', 450);

    // Disable edit on profile view
    elgg_extend_view('resources/profile/edit', 'profile/edit', 450);

	// Register search menu item fix
	elgg_register_plugin_hook_handler('register', 'menu:topbar', 'fixSearchMenuItem', 999);

	// override register action to allow multiple mails

	elgg_register_action("register", __DIR__ . "/actions/register.php");

	elgg_register_plugin_hook_handler('profile:fields', 'profile', 'hideFieldsFromSearch');

    elgg_register_plugin_hook_handler('register', 'menu:title', 'add_eventcalendar_views');

}

function fixSearchMenuItem($hook, $type, $value, $params) {
	foreach ($value as $menu_item) {
		if ($menu_item->getName() == 'search') {
			$menu_item->setPriority(10);
		}
	}
	return $value;
}

/**
 * Hide certain hidden fields from search
 */
function hideFieldsFromSearch($hook_name, $entity_type, $return_value, $parameters) {
	$context = elgg_get_context();
	if ($context == 'search' || $context == 'members') {
		unset($return_value['street']);
		unset($return_value['birthday']);
		unset($return_value['zip']);
		unset($return_value['city']);
	}
	return $return_value;
}

/**
 * Add additional views to event calendar title menu
 */
function add_eventcalendar_views($hook, $type, $return, $params) {
    if(!elgg_in_context("event_calendar")) {
        return $return;
    }
    $paged_view = new ElggMenuItem('format_paged', elgg_echo('event_calendar:settings:paged'), elgg_get_site_url() . 'event_calendar/list/?format=paged');
    $paged_view->setLinkClass('elgg-button elgg-button-action');
    $return[] = $paged_view;
    $agenda_view = new ElggMenuItem('format_agenda', elgg_echo('event_calendar:settings:agenda'), elgg_get_site_url() . 'event_calendar/list/?format=agenda');
    $agenda_view->setLinkClass('elgg-button elgg-button-action');
    $return[] = $agenda_view;
    $full_view = new ElggMenuItem('format_full', elgg_echo('event_calendar:settings:full'), elgg_get_site_url() . 'event_calendar/list/?format=full');
    $full_view->setLinkClass('elgg-button elgg-button-action');
    $return[] = $full_view;
    return $return;
}

elgg_register_event_handler('init', 'system', 'wabue_init');

