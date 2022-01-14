<?php

return [

    'update' => [
        'error'                 => 'Hiba történt frissítés közben. ',
        'success'               => 'A beállítások sikeresen frissítve.',
    ],
    'backup' => [
        'delete_confirm'        => 'Biztosan törölni szeretné ezt a biztonsági másolatot? Ez a művelet nem vonható vissza.',
        'file_deleted'          => 'A biztonsági mentés sikeresen törölve lett.',
        'generated'             => 'Új biztonsági másolatot sikerült létrehozni.',
        'file_not_found'        => 'A biztonsági másolat nem található a kiszolgálón.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Hiba történt a tisztítás során.',
        'validation_failed'     => 'A tisztítás megerősítése helytelen. Kérjük, írja be a "DELETE" szót a megerősítő mezőbe.',
        'success'               => 'A törölt rekordok sikeresen feltöltöttek.',
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
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
    ]
];
