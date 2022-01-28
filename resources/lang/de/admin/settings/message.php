<?php

return [

    'update' => [
        'error'                 => 'Während der Aktualisierung ist ein Fehler aufgetreten. ',
        'success'               => 'Die Einstellungen wurden erfolgreich aktualisiert.',
    ],
    'backup' => [
        'delete_confirm'        => 'Backup Datei wirklich löschen? Aktion kann nicht rückgängig gemacht werden. ',
        'file_deleted'          => 'Backup Datei erfolgreich gelöscht. ',
        'generated'             => 'Backup Datei erfolgreich erstellt.',
        'file_not_found'        => 'Backup Datei konnte nicht gefunden werden.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Beim Bereinigen ist ein Fehler augetreten. ',
        'validation_failed'     => 'Falsche Bereinigungsbestätigung. Bitte geben Sie das Wort "DELETE" im Bestätigungsfeld ein.',
        'success'               => 'Gelöschte Einträge erfolgreich bereinigt.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Fehler.',
        'error' => 'Something went wrong.',
    ]
];
