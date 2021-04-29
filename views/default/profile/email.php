<?php
/** @var ElggUser $user */
$user = elgg_get_page_owner_entity();

$content = '';

if ($user->email == 'noreply@waldbuehne-heessen.de') {
    $mail = elgg_echo('wabue:profile:noemail');
} else {
    $mail = $user->email;
}

$content = elgg_view('object/elements/field', [
    'label' => elgg_echo('wabue:profile:email'),
    'value' => elgg_format_element('span', [], $mail),
    'class' => 'group-profile-field',
    'name' => 'mail',
]);

echo elgg_view_module(
    'info',
    elgg_echo('wabue:profile:email'),
    $content
);


