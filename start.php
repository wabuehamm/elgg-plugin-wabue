<?php
function wabue_init() {
	// Register HypeUI CSS fixes
	elgg_extend_view('elements/layout.css', 'css/hypefixes');

	// Register E-Mail address to profile view
	elgg_extend_view('profile/details', 'profile/email');

	// Register search menu item fix
	elgg_register_plugin_hook_handler('register', 'menu:topbar', 'fixSearchMenuItem', 999);
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
