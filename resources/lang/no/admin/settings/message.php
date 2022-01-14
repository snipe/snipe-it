<?php

return [

    'update' => [
        'error'                 => 'En feil oppstod under oppdatering. ',
        'success'               => 'Oppdatering av innstillinger vellykket.',
    ],
    'backup' => [
        'delete_confirm'        => 'Er du sikker på at du vil slette denne sikkerhetskopien? Denne handlingen kan ikke angres. ',
        'file_deleted'          => 'Den Sikkerhetskopierte filen ble slettet. ',
        'generated'             => 'En ny sikkerhetskopi fil ble opprettet.',
        'file_not_found'        => 'Den backup-filen ble ikke funnet på serveren.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Det oppstod en feil under fjerning. ',
        'validation_failed'     => 'Din fjerningsbekreftelse er feil. Vennligst skriv inn ordet "DELETE" i bekreftelsesboksen.',
        'success'               => 'Slettede rader ble fjernet.',
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
