<?php

return [

    /** content subscriptions https://github.com/ColdTrick/content_subscriptions/pull/7 **/

    'content_subscriptions:subscribe' => "Abonnieren",
    'content_subscriptions:unsubscribe' => "Abbestellen",

    'admin:upgrades:content_subscriptions' => "Abonnements",
    'content_subscriptions:settings:description' => "Erhalte Benachrichtigungen, wenn Kommentare auf Deine abonnierten Inhalte gepostet werden",

    // settings
    'content_subscriptions:settings:likes' => "Bei einem Like automatisch abonnieren?",
    'content_subscriptions:settings:likes:description' => "Wenn Du etwas mit einem Like versiehst, abonnierst Du den Inhalt automatisch. (Nur verfügbar, wenn das Like-Plugin aktiviert ist)",

    // comment notifications
    'content_subscriptions:create:comment:subject' => "Neuer Kommentar bei %s",
    'content_subscriptions:create:comment:summary' => "Neuer Kommentar bei %s",
    'content_subscriptions:create:comment:message' => "Hi %s,

%s hat %s kommentiert:

%s

Schaue es Dir an und kommentiere selbst:
%s",

    // actions
    'content_subscriptions:action:subscribe:error:owner' => "Du bist der Besitzer dieses Inhalts und kannst ihn weder abonnieren noch abbestellen",
    'content_subscriptions:action:subscribe:error:subscribe' => "Ein unbekannter Fehler ist beim abonnieren aufgetreten. Bitte versuche es nochmal",
    'content_subscriptions:action:subscribe:error:unsubscribe' => "Ein unbekannter Fhler ist beim abbestellen aufgetreten . Bitte versuche es nochmal",
    'content_subscriptions:action:subscribe:success:subscribe' => "Du hast diesen Inhalt erfolgreich abonniert",
    'content_subscriptions:action:subscribe:success:unsubscribe' => "Das Abonnement wurde erfolgreich abbestellt",

    // Play applications
    'wabue:play' => 'Stück',

    // Overridden event calender

    'event_calendar:region_label' => 'Art',
    'event_calendar:region_filter_by_label' => 'Nach Art filtern',

    // advanced comments

    'advanced_comments' => "Advanced comments",
	
	'advanced_comments:header:order' => "Kommentarsortierung",
	'advanced_comments:header:order:asc' => "Älteste zuerst",
	'advanced_comments:header:order:desc' => "Neuste zuerst",
	
	'advanced_comments:header:limit' => "Maximale Anzahl",
	'advanced_comments:header:auto_load' => "Automatisch laden",
	
	'advanced_comments:comment:logged_out' => "Das Kommentieren ist nur für angemeldete Nutzer erlaubt",
	
	'advanced_comments:settings:auto_load:help' => "Automatisch die nächsten Kommentare laden, wenn der Benutezr das Ende der Seite erreicht",
	'advanced_comments:settings:user_preference' => "Dürfen Benutzer die Kommentareinstellungen verändern?",
	'advanced_comments:settings:show_login_form' => "Das Anmeldeformular für nicht angemeldete Benutzer unter den Kommentaren anzeigen",
	'advanced_comments:settings:allow_group_comments' => "Nicht-Mitgliedern einer Gruppe erlauben, etwas in der Gruppe zu kommentieren",
	'advanced_comments:settings:allow_group_comments:help' => "Wenn ein Benutzer den Inhalt einer Gruppe, von der er nicht Mitglied ist, sehen kann, darf er kommentieren.",

];
