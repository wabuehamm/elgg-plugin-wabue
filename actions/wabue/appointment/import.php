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
use PhpOffice\PhpSpreadsheet\Shared;

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

$errors = [];
$events_imported = 0;

foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
    $current_user = elgg_get_logged_in_user_entity();
    $headersValid = false;
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);
        $row_text = implode(',', iterator_to_array($cellIterator));
        if (
            $row->isEmpty(
                CellIterator::TREAT_NULL_VALUE_AS_EMPTY_CELL | CellIterator::TREAT_EMPTY_STRING_AS_EMPTY_CELL
            )
        ) {
            continue;
        }
        if (!$headersValid) {
            foreach ($headers as $index => $header) {
                if (!($worksheet->getCell([$index + 1, $row->getRowIndex()])->getValue() == $header)) {
                    $errors[] = "Worksheet " . $worksheet->getTitle() . " doesn't match header validation. Skipping";
                    continue 3;
                }
            }
            $headersValid = true;
            continue;
        }
        $event = [];
        /** @var ElggUser $organizer */
        $organizer = null;
        /** @var DateTime $fromDate */
        $from = null;
        /** @var DateTime $toDate */
        $to = null;
        /** @var string $type */
        $type = null;
        foreach ($headers as $index => $header) {
            $value = $worksheet->getCell([$index + 1, $row->getRowIndex()])->getValue();
            switch ($header) {
                case "Von Wann":
                    $from = Shared\Date::excelToDateTimeObject($value);
                    break;
                case "Bis Wann":
                    $to = Shared\Date::excelToDateTimeObject($value);
                    break;
                case "Art":
                    if (!in_array($value, $valid_types)) {
                        $errors[] = "Type $value not valid. Skipping row: $row_text";
                        continue 3;
                    }
                    $type = $value;
                    break;
                case "Ansprechpartner":
                    $organizer = elgg_get_user_by_username($value);
                    if (!$organizer) {
                        $errors[] = "User $value not found. Skipping row: $row_text";
                        continue 3;
                    }
                    break;
                default:
                    $event[$header] = $value;
            }
        }
        if (is_null($from)) {
            $errors[] = "No start date specified. Skipping row: $row_text";
            continue;
        }
        if (is_null($to)) {
            $errors[] = "No end date specified. Skipping row: $row_text";
            continue;
        }
        if ($to < $from) {
            $errors[] = "End date is before start date. Skipping row: $row_text";
            continue;
        }
        if ($to == $from) {
            $errors[] = "End date can not be equal to start date. Skipping row: $row_text";
            continue;
        }
        if (is_null($organizer)) {
            $errors[] = "No organizer specified. Skipping row: $row_text";
            continue;
        }
        if (count($event) < 3) {
            $errors[] = "Did not catch all required event cells. Skipping row: $row_text";
            continue;
        }
        elgg_call(
            ELGG_IGNORE_ACCESS,
            function () use (
                $value,
                $from,
                $to,
                $organizer,
                $event,
                $current_user,
                $type,
                $check_only,
                $events_imported
            ) {
                $event_object = new Event();
                $event_object->event_start = $from->getTimestamp();
                $event_object->event_end = $to->getTimestamp();
                $event_object->access_id = 1;
                $event_object->title = $event['Was'];
                $event_object->description = $event['Wer'];
                $event_object->location = $event['Wo'];
                $event_object->event_type = $type;
                $event_object->owner_guid = $organizer;
                if (!$check_only) {
                    $event_object->save();
                }
            }
        );
        $events_imported++;
    }
}

if (count($errors) > 0) {
    return elgg_error_response(
        elgg_echo('wabue:appointment:import:error', [$events_imported]),
        elgg_generate_url(
            'view:uploadappointments',
            [
                'errors' => substr(join('<br />', $errors), 0, 2000),
                'events_imported' => $events_imported
            ]
        )
    );
} else {
    return elgg_ok_response(
        '',
        elgg_echo('wabue:appointment:import:successful', [$events_imported]),
        elgg_generate_url('view:uploadappointments')
    );
}
