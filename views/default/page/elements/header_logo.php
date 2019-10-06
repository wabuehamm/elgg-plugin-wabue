<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();

echo elgg_format_element('h1', ['class' => 'elgg-heading-site'], elgg_view('output/url', [
	'text' => elgg_view('output/img', [
		src => elgg_get_simplecache_url('topbar_logo.png'),
		alt => $site->getDisplayName()
	]),
	'href' => $site->getURL(),
	'is_trusted' => true,
]));
