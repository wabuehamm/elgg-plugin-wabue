/**
 * Fixes event calendar
 */
function fixProfile() {
    // disable Mitglied seit

    $('input[name="member_since"]').attr('disabled', 'disabled');

    // disable Senior since

    $('input[name="senior_since"]').attr('disabled', 'disabled');

    // remove Aussetzjahre

    $('label[for="profile-away_years"]').hide();
    $('input[name="away_years"]').hide();

}


$.when($.ready).then(fixProfile);
