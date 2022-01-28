<?php

return [

    'update' => [
        'error'                 => 'Ett fel har uppstått under uppdateringen.',
        'success'               => 'Inställningarna uppdaterades framgångsrikt.',
    ],
    'backup' => [
        'delete_confirm'        => 'Är du säker på att du vill ta bort den här säkerhetskopieringsfilen? Den här åtgärden kan inte ångras.',
        'file_deleted'          => 'Säkerhetsfilen har tagits bort.',
        'generated'             => 'En ny säkerhetskopieringsfil skapades med framgång.',
        'file_not_found'        => 'Den säkerhetskopieringsfilen kunde inte hittas på servern.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Ett fel har uppstått vid spolning.',
        'validation_failed'     => 'Din rengöringsbekräftelse är felaktig. Vänligen skriv ordet "DELETE" i bekräftelsen rutan.',
        'success'               => 'Raderade poster som rensats framgångsrikt.',
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
