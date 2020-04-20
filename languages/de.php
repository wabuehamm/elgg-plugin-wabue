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

    // translation hotfix for engine

    'email:from' => 'Von',
	'email:to' => 'An',
	'email:subject' => 'Betreff',
	'email:body' => 'Email-Text',

	'email:settings' => "Email",
	'email:address:label' => "Email-Adresse",
	'email:address:help:confirm' => "E-Mailadressänderungen nach '%s' steht aus. Bitte überprüfe Deinen Posteingang für mehr Informationen.",
	'email:address:password' => "Passwort",
	'email:address:password:help' => "Für die Änderung Deiner Email-Adresse ist die Eingabe Deines derzeitigen Passworts notwendig.",

	'email:save:success' => "Die neue Email-Adresse wurde gespeichert. Eine Verifizierungs-Email wurde versandt.",
	'email:save:fail' => "Die neue Email-Adresse konnte nicht gespeichert werden.",
	'email:save:fail:password' => "Das eingegebene Passwort ist nicht gleich Deinem derzeitigen Passwort. Daher kann Deine neue Email-Adresse nicht gespeichert werden.",

	'friend:newfriend:subject' => "Du bist nun mit %s befreundet!",
	'friend:newfriend:body' => "Du bist nun mit %s befreundet!

Um ihr/sein Profil aufzurufen, folge diesem Link:

%s",

	'email:changepassword:subject' => "Änderung des Passworts!",
	'email:changepassword:body' => "Hallo %s,

Dein Passwort wurde geändert.",

	'email:resetpassword:subject' => "Zurücksetzung des Passworts!",
	'email:resetpassword:body' => "Hallo %s,

Dein Passwort wurde zurückgesetzt. Dein neues Passwort ist: %s",

	'email:changereq:subject' => "Verifizierung der Änderung Deines Passworts.",
	'email:changereq:body' => "Hallo %s,

es wurde eine Änderung des Passworts Deines Accounts angefordert (von der IP-Adresse %s).

Falls Du die Änderung des Passworts angefordert hast, klicke bitte auf den folgenden Link, um dies zu bestätigen:

%s

Andernfalls ignoriere bitte diese Email.",

	'account:email:request:success' => "Deine neue E-Mailadresse muss zunächst bestätigt werden. Bitte überprüfe den Posteingang der Adresse '%s' für weitere Informationen.",
	'email:request:email:subject' => "Bitte bestätige Deine E-Mailadress",
	'email:request:email:body' => "Hallo %s,

Du hast eine Änderung Deiner E-Mailadresse auf '%s' angefordert.
Wenn Du diese Änderung nicht angefordert hast, kannst Du diese Mail ignorieren.

Um Deine E-Mailadressänderung zu bestätigen, klicke bitte auf diesen Link:
%s

Dieser Link ist eine Stunde gültig.",

	'account:email:request:error:no_new_email' => "Keine ausstehenden E-Mailadressänderungen.",

	'email:confirm:email:old:subject' => "Deine E-Mailadresse wurde geändert.",
	'email:confirm:email:old:body' => "Hi %s,

Deine E-Mailadresse für '%s' wurde geändert.
Von nun an erhältst Du Benachrichtigungen an '%s'.

Wenn Du das nicht angefordert hast, kontaktiere bitte Deinen Administrator.
%s",

	'email:confirm:email:new:subject' => "Deine E-Mailadresse wurde geändert.",
	'email:confirm:email:new:body' => "Hi ,

Deine E-Mailadresse für '%s' wurde geändert.
Von nun an erhältst Du Benachrichtigungen an '%s'.

Wenn Du das nicht angefordert hast, kontaktiere bitte Deinen Administrator.
%s",

	'account:email:admin:validation_notification' => "Benachrichtige mich, wenn es Benutzer gibt, die durch einen Administrator überprüft werden müssen",
	'account:email:admin:validation_notification:help' => "Aufgrund der Site-Einstellungen, müssen neuregistrierte Benutzer von einem Administrator manuell überprüft werden. Mit dieser Einstellung kannst Du Benachrichtigungen über ausstehende Überprüfungen abschalten.",

	'account:validation:pending:title' => "",
	'account:validation:pending:content' => "",

	'account:notification:validation:subject' => "",
	'account:notification:validation:body' => "",

    'wabue:settings:testmode:label' => 'Test-Modus',
    'wabue:settings:testmode:help' => 'Eher unsichere Erweiterungen aktivieren. Sollte nur angeschaltet werden, wenn das System sich im Testmodus befindet'

];
