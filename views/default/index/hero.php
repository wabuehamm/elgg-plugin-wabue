<?php
$module = elgg_extract('hero_module', $vars);
if (!$module) {
	if (!elgg_is_logged_in()) {
		$title = elgg_extract('title', $vars, elgg_echo('login'));
		$body = elgg_view_form('login');
		$module = elgg_view_module('hero', $title, $body, [
			'class' => 'hero is-white',
		]);
	}
}
?>
<div class="hero is-primary is-fullheight elgg-hero-index">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-vcentered">
                <div class="column is-4 is-offset-4">
					<?php
					echo $module;
					?>
                </div>
            </div>
        </div>
    </div>
</div>
