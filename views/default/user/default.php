<?php
/**
 * Elgg user display
 *
 * @uses $vars['entity'] ElggUser entity
 * @uses $vars['size']   Size of the icon
 * @uses $vars['title']  Optional override for the title
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggUser) {
    return;
}

$showEntity = false;
$senior_since = $entity->getProfileData('senior_since');
if (elgg_is_admin_logged_in()) {
    $showEntity = true;
} elseif ($senior_since && (intval($senior_since)) <= intval(strftime('%Y'))) {
    $showEntity = true;
} elseif ($entity->getProfileData('deathday')) {
    $showEntity = true;
} elseif (!$entity->isBanned()) {
    $showEntity = true;
}

if ($showEntity) {
    $size = elgg_extract('size', $vars, 'small');

    if (elgg_get_context() == 'gallery') {
        echo elgg_view_entity_icon($entity, $size, $vars);
        return;
    }

    $title = elgg_extract('title', $vars);
    if (!$title) {
        $title = elgg_view('output/url', [
            'href' => $entity->getUrl(),
            'text' => $entity->getDisplayName(),
            'is_trusted' => true,
        ]);
    }

    $params = [
        'entity' => $entity,
        'title' => $title,
        'icon_entity' => $entity,
        'icon_size' => $size,
        'tags' => false,
    ];
    $params = $params + $vars;

    echo elgg_view('user/elements/summary', $params);
}
