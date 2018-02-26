<div id="profile-email">
<?php
$user = elgg_get_page_owner_entity();
?>
<b>E-Mail:</b> <a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a>
</div>
