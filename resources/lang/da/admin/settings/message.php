<?php

return [

    'update' => [
        'error'                 => 'Der opstod en fejl under opdatering. ',
        'success'               => 'Indstillinger opdateret med succes.',
    ],
    'backup' => [
        'delete_confirm'        => 'Er du sikker på, at du vil slette denne sikkerhedskopieringsfil? Denne handling kan ikke fortrydes.',
        'file_deleted'          => 'Sikkerhedsfilen blev slettet korrekt.',
        'generated'             => 'En ny sikkerhedskopieringsfil blev oprettet.',
        'file_not_found'        => 'Denne backup-fil kunne ikke findes på serveren.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Der opstod en fejl under udrensning.',
        'validation_failed'     => 'Din udrensningsbekræftelse er forkert. Indtast ordet "DELETE" i bekræftelsesboksen.',
        'success'               => 'Slettet arkiver, der er renset for succes.',
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
    'webhook' => [
        'sending' => 'Sending :app test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. :app responded with: :error_message',
        'error_misc' => 'Something went wrong. :( ',
    ]
];
