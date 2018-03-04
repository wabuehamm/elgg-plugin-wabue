<?php
function wabue_init() {
	// Register HypeUI CSS fixes
	elgg_extend_view('elements/layout.css', 'css/hypefixes');
	elgg_extend_view('resources/event_calendar/edit', 'event_calendar/edit', 450);

	// Register E-Mail address to profile view
	elgg_extend_view('profile/details', 'profile/email');

    // Disable edit on profile view
    elgg_extend_view('resources/profile/edit', 'profile/edit', 450);

	// Register search menu item fix
	elgg_register_plugin_hook_handler('register', 'menu:topbar', 'fixSearchMenuItem', 999);

	// override register action to allow multiple mails

	elgg_register_action("register", __DIR__ . "/actions/register.php");

	//elgg_register_page_handler('wabue', 'wabue_pagehandler');

}

function fixSearchMenuItem($hook, $type, $value, $params) {
	foreach ($value as $menu_item) {
		if ($menu_item->getName() == 'search') {
			$menu_item->setPriority(10);
		}
	}
	return $value;
}

function wabue_pagehandler($sections) {

	if ($sections[0] == 'clean') {
		if ($sections[1] == 'user') {
			$users = elgg_get_entities(["types" => "user", "limit" => 0]);
			echo "Deleting " . count($users) . " users...";
			$blacklist = ["ploeger", "oliver.lange", "samuel.hesse", "thorsten.huebner"];
			foreach ($users as $user) {
				if (!in_array($user->username, $blacklist)) {
					$user->delete();
				}
			}

		} else if ($sections[1] == 'calendar') {

			$events = elgg_get_entities(["types" => "object", "subtypes" => "event_calendar", "limit" => 0]);
			echo "Deleting " . count($events) . " events...";
			foreach ($events as $event) {
				$event->delete();
			}

		} else if ($sections[1] == 'forum') {
			$replies = elgg_get_entities(["types" => "object", "subtypes" => "discussion_reply", "limit" => 0]);
			echo "Deleting " . count($replies) . " replies...";
			foreach ($replies as $reply) {
				$reply->delete();
			}

			$topics = elgg_get_entities(["types" => "object", "subtypes" => "discussion", "limit" => 0]);
			echo "Deleting " . count($topics) . " topics...";
			foreach ($topics as $topic) {
				$topic->delete();
			}
		}
	}
}

elgg_register_event_handler('init', 'system', 'wabue_init');

