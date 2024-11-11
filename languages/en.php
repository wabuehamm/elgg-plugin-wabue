<?php

return [

    'wabue:profile:email' => 'E-Mail',
    'wabue:profile:noemail' => 'No E-Mail specified',

    'wabue:appointment:import' => 'Import appointments',
    'wabue:settings:appointmentusers:label' => 'Users that can upload appointments',
    'wabue:settings:appointmentusers:help' => 'Usernames that can use the excel upload for appointments. One user per line',
    'wabue:appointments:gatekeeper:error' => 'You are not allowed to use this service',
    'wabue:appointment:import:error' => 'There were errors loading the appointments. %d appointments loaded successfully',
    'wabue:appointment:import:successful' => 'Successfully loaded %d appointments',
    'wabue:appointment:import:file:label' => 'Event-File',
    'wabue:appointment:import:file:help' => 'An Excel file containing worksheets that hold the appointments to be imported using the headers Was, Von Wann, Bis Wann, Wer, Wo, Art and Ansprechpartner',
    'wabue:appointment:import:submit' => 'Import',
    'wabue:appointment:import:intro' => 'Please upload the appointments formatted in an Excel file. Please use the <a href="%s">commented template</a> as a default.',

    'wabue:appointment:import:check:label' => 'Only check import',
    'wabue:appointment:import:check:help' => "Don't import events, only validate import",
    'senior' => 'Senior',
    'deceased' => 'Deceased',
];
