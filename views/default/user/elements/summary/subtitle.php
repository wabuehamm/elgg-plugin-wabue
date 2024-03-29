<?php
/**
 * Outputs user subtitle
 *
 * @uses $vars['subtitle'] Subtitle
 * @uses $vars['entity']   The ElggUser
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggUser) {
    return;
}

if (!$entity->isBanned()) {
    $subtitle = elgg_extract('subtitle', $vars);
    if (!isset($subtitle)) {
        $subtitle = elgg_view('user/elements/imprint', $vars);
    }
} else {
    // user is banned
    $subtitle = elgg_echo('banned');
}

$senior_since = $entity->getProfileData('senior_since');
if ($entity->getProfileData('deathday')) {
    $subtitle = elgg_echo('deceased');
} elseif ($senior_since && (intval($senior_since)) <= intval(strftime('%Y'))) {
    $subtitle = elgg_echo('senior');
}

if (elgg_is_empty($subtitle)) {
    return;
}

echo elgg_format_element('div', [
    'class' => [
        'elgg-listing-summary-subtitle',
        'elgg-subtext',
    ]
], $subtitle);
