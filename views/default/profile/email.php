<?php
if (!elgg_is_admin_logged_in()) {
    // disable certain profile fields for non-admins
    echo elgg_require_js("js/fixProfileFields");
}
?>
<div id="profile-email">
<?php
$user = elgg_get_page_owner_entity();
if ($user->email == 'noreply@waldbuehne-heessen.de') {
?>
    <b>E-Mail:</b> noch keine Adresse angegeben
<?php
} else {

?>
<b>E-Mail:</b> <a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a>
<?php
}

?>
</div>


