<?php

if (!elgg_is_admin_logged_in()) {
    // disable certain profile fields for non-admins
    echo elgg_require_js("js/fixProfile");
}
