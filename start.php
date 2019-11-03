<?php

global $play_application_fields, $private_fields;

// Fields of the season application
$play_application_fields = [
    'regie', 
    'spieler', 
    'maske', 
    'technik', 
    'pyrotechnik', 
    'kasse', 
    'ordner', 
    'verkaufsbuden', 
    'kaffeekueche', 
    'theke_studio', 
    'kueche_studio'
];

// Profile fields, that remain private
$private_fields = array_merge($play_application_fields, ['street', 'zip', 'city', 'birthday', 'common']);

function wabue_init() {
    // Register Wabue CSS modifications
    elgg_extend_view('elements/layout.css', 'css/wabue');

    // Walled Garden CSS extensions
    elgg_extend_view('walled_garden.css', 'walled_garden_title.css', 450);

    // hide irrelevant fields from event editor
	elgg_extend_view('resources/event_calendar/edit', 'event_calendar/edit', 450);

	// Register E-Mail address to profile view
	elgg_extend_view('profile/details', 'profile/email');

    // Show extra fields automatically on useradd
	elgg_extend_view('forms/useradd', 'forms/useradd_profile_fix', 999);

    // Disable edit on profile view
    elgg_extend_view('resources/profile/edit', 'profile/edit', 450);

	// Register search menu item fix
	elgg_register_plugin_hook_handler('register', 'menu:topbar', 'fixSearchMenuItem', 999);

	// override register action to allow multiple mails
	elgg_register_action("register", __DIR__ . "/actions/register.php");

	// Add region select to event calendar sidebar
    elgg_extend_view('event_calendar/sidebar', 'event_calendar/sidebar_region_select', 450);

    // Set private access level on defined fields
    elgg_register_event_handler('profileupdate', 'user', 'set_fields_accesslevel');

    // Page handler
    elgg_register_page_handler('wabue', 'wabue_page_handler');

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
 * Force access level for private fields to private
 */
function set_fields_accesslevel($event, $object_type, $object) {
    global $private_fields;

    if ($event == 'profileupdate' && $object_type == 'user') {
        foreach ($private_fields as $metadata) {
            $object->setProfileData($metadata, $object->getProfileData($metadata), ACCESS_PRIVATE);
        }
    }
    return true;
}

/**
 * Wabue page handler
 */

function wabue_page_handler(array $segments) {
    global $play_application_fields;

    $subpage = elgg_extract(0, $segments);

    if ($subpage == 'export') {
        if (!elgg_get_logged_in_user_entity()->isAdmin()) {
            // Export is only allowed as admin
            return;
        }
        $export_page = elgg_extract(1, $segments);
        if ($export_page == 'users') {
            // user exports
            $user_export_type = elgg_extract(2, $segments);
            if ($user_export_type == 'applications') {
                // user applications export
                $application_type = elgg_extract(3, $segments);
                if ($application_type == 'plays') {
                    // play applications
                    header('Content-Type: text/csv');
                    echo elgg_view('export/users/applications/plays', array(
                        'application_fields' => $play_application_fields
                    ), false, false, 'csv');
                } else if ($application_type == 'common') {
                    // common applications
                    header('Content-Type: text/csv');
                    echo elgg_view('export/users/applications/common', array(), false, false, 'csv');
                }
            }
            
        }
    }
}

function add_cli_commands($hook, $type, $return) {
    $return[] = Wabue\PrioritizeCommand::class;
    return $return;
}

elgg_register_event_handler('init', 'system', 'wabue_init');

