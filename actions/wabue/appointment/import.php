<?php

/**
 * Definition of a valid worksheet:
 *
 * - empty lines are ignored
 * - first (filled) line should confirm to $headers
 * - "Von Wann" and "Bis Wann" should have the form of YYYY-MM-DD HH:MM
 * - Art must be one of $valid_types
 * - "Ansprechpartner" has to be a valid username
 */

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\CellIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;

$headers = [
    "Was",
    "Von Wann",
    "Bis Wann",
    "Wer",
    "Wo",
    "Art",
    "Ansprechpartner",
];

$valid_types = [
    "Arbeitseinsatz",
    "Workshop",
    "Vereinsfeier",
    "Vereinsfahrt",
    "Private Feier",
    "Besprechung",
    "Vereinsgruppen",
    "Wintertheater",
    "Vormittag",
    "Nachmittag",
    "Abend",
];

$check_only = get_input('check', 'yes') == 'yes';
$file = elgg_get_uploaded_file('import');
$spreadsheet = IOFactory::load($file);

elgg_log('Scanning uploaded spreadsheet');

/**
 * Parses the given string in the required format and returns null on errors or a well formatted date for
 * elgg
 * @param $value string date string
 * @return null|array An array with "date" (epoch of the given date) and "time" (minutes since midnight on the given date) or null if the string could not be parsed
 */
function parse_input_date(string $value): ?array
{
    $parsed_date = date_parse_from_format("Y-m-d H:i", $value);
    if ($parsed_date["error_count"] > 0) {
        return null;
    }
    return [
        "epoch" => mktime($parsed_date['hour'], $parsed_date['minute'], 0, $parsed_date['month'], $parsed_date['day'], $parsed_date['year']),
        "date" => explode(" ", $value)[0],
        "time_hour" => $parsed_date['hour'],
        "time_minute" => $parsed_date['minute']
    ];
}
$errors = [];
$events_imported = 0;

foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
    $current_user = elgg_get_logged_in_user_entity();
    $headersValid = false;
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);
        $row_text = implode(',', iterator_to_array($cellIterator));
        if ($row->isEmpty(CellIterator::TREAT_NULL_VALUE_AS_EMPTY_CELL | CellIterator::TREAT_EMPTY_STRING_AS_EMPTY_CELL)) {
            continue;
        }
        if (!$headersValid) {
            foreach ($headers as $index => $header) {
                if (!($worksheet->getCellByColumnAndRow($index + 1, $row->getRowIndex())->getValue() == $header)) {
                    $errors[] = "Worksheet " . $worksheet->getTitle() . " doesn't match header validation. Skipping";
                    continue 3;
                }
            }
            $headersValid = true;
            continue;
        }
        $event = [];
        $organizer = null;
        $fromDate = null;
        $toDate = null;
        $type = null;
        foreach ($headers as $index => $header) {
            $value = $worksheet->getCellByColumnAndRow($index + 1, $row->getRowIndex())->getValue();
            switch ($header) {
                case "Von Wann":
                    $fromDate = parse_input_date($value);
                    if (!$fromDate) {
                        $errors[] = "From date in row has not the right format: $value. Skipping row: $row_text";
                        continue 3;
                    }
                    break;
                case "Bis Wann":
                    $toDate = parse_input_date($value);
                    if (!$toDate) {
                        $errors[] = "To date in row has not the right format: $value. Skipping row: $row_text";
                        continue 3;
                    }
                    break;
                case "Art":
                    if (!in_array($value, $valid_types)) {
                        $errors[] = "Type $value not valid. Skipping row: $row_text";
                        continue 3;
                    }
                    $type = $value;
                    break;
                case "Ansprechpartner":
                    $organizer = get_user_by_username($value);
                    if (!$organizer) {
                        $errors[] = "User $value not found. Skipping row: $row_text";
                        continue 3;
                    }
                    break;
                default:
                    $event[$header] = $value;
            }
        }
        if (!$fromDate) {
            $errors[] = "No start date specified. Skipping row: $row_text";
            continue;
        }
        if (!$toDate) {
            $errors[] = "No end date specified. Skipping row: $row_text";
            continue;
        }
        if ($toDate['epoch'] < $fromDate['epoch']) {
            $errors[] = "End date is before start date. Skipping row: $row_text";
            continue;
        }
        if ($toDate['epoch'] == $fromDate['epoch']) {
            $errors[] = "End date can not be equal to start date. Skipping row: $row_text";
            continue;
        }
        if (!$organizer) {
            $errors[] = "No organizer specified. Skipping row: $row_text";
            continue;
        }
        if (count($event) < 3) {
            $errors[] = "Did not catch all required event cells. Skipping row: $row_text";
            continue;
        }
        elgg_call(ELGG_IGNORE_ACCESS, function () use ($value, $fromDate, $toDate, $organizer, $event, $current_user, $type, $check_only, $events_imported) {
            set_input('schedule_type', 'fixed');
            set_input('start_date', $fromDate['date']);
            set_input('end_date', $toDate['date']);
            set_input('start_time_hour', $fromDate['time_hour']);
            set_input('start_time_minute', $fromDate['time_minute']);
            set_input('end_time_hour', $toDate['time_hour']);
            set_input('end_time_minute', $toDate['time_minute']);
            set_input('access_id', 1);
            set_input('title', $event['Was']);
            set_input('description', $event['Wer']);
            set_input('venue', $event['Wo']);
            set_input('region', $type);
            if (!$check_only) {
                $session = elgg()->session;
                $session->setLoggedInUser($organizer);
                event_calendar_set_event_from_form(0, 0);
                $session->setLoggedInUser($current_user);
            }
        });
        $events_imported++;
    }
}

if (count($errors) > 0) {
    return elgg_error_response(
        elgg_echo('wabue:appointment:import:error', [$events_imported]),
        elgg_generate_url('view:uploadappointments', ['errors' => substr(join('<br />', $errors),0, 2000), 'events_imported' => $events_imported])
    );
} else {
    return elgg_ok_response(
        '',
        elgg_echo('wabue:appointment:import:successful', [$events_imported]),
        elgg_generate_url('view:uploadappointments')
    );
}
