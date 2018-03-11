<?php
function wabue_init() {
	// Register HypeUI CSS fixes
	elgg_extend_view('elements/layout.css', 'css/hypefixes');
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

}

function fixSearchMenuItem($hook, $type, $value, $params) {
	foreach ($value as $menu_item) {
		if ($menu_item->getName() == 'search') {
			$menu_item->setPriority(10);
		}
	}
	return $value;
}

elgg_register_event_handler('init', 'system', 'wabue_init');

