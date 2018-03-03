/**
 * Fixes event calendar
 */
function fixEventCalendar() {
    // hide Beschreibung

    $('label:contains("Beschreibung")').hide();
    $('input[name="description"]').hide();

    // hide Gebühr

    $('label:contains("Gebühr")').hide();
    $('input[name="fees"]').hide();

    // hide Kontakt

    $('label:contains("Kontakt")').hide();
    $('input[name="contact"]').hide();

    // hide Veranstalter

    $('label:contains("Veranstalter")').hide();
    $('input[name="organiser"]').hide();

}


$.when($.ready).then(fixEventCalendar);