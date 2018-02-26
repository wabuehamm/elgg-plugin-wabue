<?php
function wabue_init() {
	elgg_extend_view('elements/layout.css', 'css/hypefixes');
	elgg_extend_view('profile/details', 'profile/email');
}

elgg_register_event_handler('init', 'system', 'wabue_init');

