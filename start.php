<?php
function wabue_init() {
	// Register HypeUI CSS fixes
	elgg_extend_view('elements/layout.css', 'css/hypefixes');

    // Register Wabue CSS modifications
    elgg_extend_view('elements/layout.css', 'css/wabue');

    // hide irrelevant fields from event editor
	elgg_extend_view('resources/event_calendar/edit', 'event_calendar/edit', 450);

	// Register E-Mail address to profile view
	elgg_extend_view('profile/details', 'profile/email');

	// Move date picker to sidebar
    elgg_extend_view('event_calendar/agenda_view', 'event_calendar/agenda_view_fix', 450);

    // Disable edit on profile view
    elgg_extend_view('resources/profile/edit', 'profile/edit', 450);

	// Register search menu item fix
	elgg_register_plugin_hook_handler('register', 'menu:topbar', 'fixSearchMenuItem', 999);

	// override register action to allow multiple mails
	elgg_register_action("register", __DIR__ . "/actions/register.php");

	// Add additional views to event calendar
    elgg_register_plugin_hook_handler('register', 'menu:title', 'add_eventcalendar_additional_views');

    // Set private access level on defined fields
    elgg_register_event_handler('profileupdate', 'user', 'set_fields_accesslevel');

}

/**
 * Fix search menu item menu priority
 */
function fixSearchMenuItem($hook, $type, $value, $params) {
	foreach ($value as $menu_item) {
		if ($menu_item->getName() == 'search') {
			$menu_item->setPriority(10);
		}
	}
	return $value;
}

/**
 * Add additional views to event calendar title menu
 */
function add_eventcalendar_additional_views($hook, $type, $return, $params) {
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

function set_fields_accesslevel($event, $object_type, $object) {
    // to fix prod:
    // update elgg_metadata set access_id=0 where name_id in (select id from elgg_metastrings where string in ('street', 'zip', 'city', 'birthday'));
    // update elgg_metadata set owner_guid=entity_guid where name_id in (select id from elgg_metastrings where string in ('street', 'zip', 'city', 'birthday'));
    if ($event == 'profileupdate' && $object_type == 'user') {
        foreach (array('street', 'zip', 'city', 'birthday') as $metadata) {
            $object->setMetadata($metadata, $object->getMetadata($metadata), '', false, $object->guid, ACCESS_PRIVATE);
        }
    }
    return true;
}

elgg_register_event_handler('init', 'system', 'wabue_init');

