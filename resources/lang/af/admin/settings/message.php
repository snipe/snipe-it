<?php

return [

    'update' => [
        'error'                 => '\'N Fout het voorgekom tydens opdatering.',
        'success'               => 'Stellings suksesvol opgedateer.',
    ],
    'backup' => [
        'delete_confirm'        => 'Is jy seker jy wil hierdie rugsteunlêer uitvee? Hierdie handeling kan nie ongedaan gemaak word nie.',
        'file_deleted'          => 'Die rugsteunlêer is suksesvol verwyder.',
        'generated'             => '\'N Nuwe rugsteunlêer is suksesvol geskep.',
        'file_not_found'        => 'Daardie rugsteunlêer kon nie op die bediener gevind word nie.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => '\'N Fout het voorgekom tydens suiwering.',
        'validation_failed'     => 'Jou skoonmaakbevestiging is verkeerd. Tik asseblief die woord "DELETE" in die bevestigingsboks.',
        'success'               => 'Geskrapte rekords verwyder.',
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
