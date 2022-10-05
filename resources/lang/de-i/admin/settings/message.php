<?php

return [

    'update' => [
        'error'                 => 'Während der Aktualisierung ist ein Fehler aufgetreten. ',
        'success'               => 'Die Einstellungen wurden erfolgreich aktualisiert.',
    ],
    'backup' => [
        'delete_confirm'        => 'Backup Datei wirklich löschen? Aktion kann nicht rückgängig gemacht werden. ',
        'file_deleted'          => 'Backup Datei erfolgreich gelöscht. ',
        'generated'             => 'Neue Backup Datei erfolgreich erstellt.',
        'file_not_found'        => 'Backup Datei konnte nicht gefunden werden.',
        'restore_warning'       => 'Ja, wiederherstellen. Ich bestätige, dass dies alle vorhandenen Daten überschreibt, die derzeit in der Datenbank vorhanden sind. Diese Aktion wird auch alle bestehenden Benutzer abmelden (einschließlich Dir).',
        'restore_confirm'       => 'Bist Du sicher, dass Du Deine Datenbank aus :filename wiederherstellen möchten?'
    ],
    'purge' => [
        'error'     => 'Beim Bereinigen ist ein Fehler augetreten. ',
        'validation_failed'     => 'Falsche Bereinigungsbestätigung. Bitte gib das Wort "DELETE" im Bestätigungsfeld ein.',
        'success'               => 'Gelöschte Einträge erfolgreich bereinigt.',
    ],
    'mail' => [
        'sending' => 'Test E-Mail wird gesendet...',
        'success' => 'Mail gesendet!',
        'error' => 'E-Mail konnte nicht gesendet werden.',
        'additional' => 'Keine zusätzliche Fehlermeldung vorhanden. Überprüfe Deine E-Mail-Einstellungen und Dein App-Protokoll.'
    ],
    'ldap' => [
        'testing' => 'Teste LDAP Verbindung, Binding & Abfrage ...',
        '500' => '500 Serverfehler. Bitte überprüfe Deine Server-Logs für weitere Informationen.',
        'error' => 'Etwas ist schiefgelaufen :(',
        'sync_success' => 'Ein Beispiel von 10 Benutzern, die vom LDAP-Server basierend auf Deinen Einstellungen zurückgegeben wurden:',
        'testing_authentication' => 'LDAP-Authentifizierung wird getestet...',
        'authentication_success' => 'Benutzer wurde erfolgreich gegen LDAP authentifiziert!'
    ],
    'slack' => [
        'sending' => 'Slack Testnachricht wird gesendet...',
        'success_pt1' => 'Erfolgreich! Überprüfe die ',
        'success_pt2' => ' kanal für Deine Testnachricht, und klicke auf Speichern unten, um Deine Einstellungen zu speichern.',
        '500' => '500 Server Fehler.',
        'error' => 'Etwas ist schiefgelaufen.',
    ]
];
