/**
 * Fixes event calendar
 */
function fixProfile() {
    // disable Mitglied seit

    $('input[name="member_since"]').attr('disabled', 'disabled');


    // disable Aussetzjahre

    $('input[name="away_years"]').attr('disabled', 'disabled');

}


$.when($.ready).then(fixProfile);