/**
 * Fixes event calendar's agenda view
 */
function fixEventCalendar() {
    // move date selection to the sidebar

    $('#my_datepicker').parent().prependTo($('.elgg-layout-sidebar .elgg-inner'));
    $('#my_datepicker').parent().addClass("event_navigator")

}


$.when($.ready).then(fixEventCalendar);
