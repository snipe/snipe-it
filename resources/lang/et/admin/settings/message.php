<?php

return [

    'update' => [
        'error'                 => 'Uuendamise ajal on ilmnenud viga.',
        'success'               => 'Seaded uuendati edukalt.',
    ],
    'backup' => [
        'delete_confirm'        => 'Kas olete kindel, et soovite varundamisfaili kustutada? Seda toimingut ei saa tagasi võtta.',
        'file_deleted'          => 'Varundusfail kustutati edukalt.',
        'generated'             => 'Uus varundamisfail loodi edukalt.',
        'file_not_found'        => 'Seda varundamisfaili ei leitud serverist.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Puhastamise ajal on tekkinud viga.',
        'validation_failed'     => 'Teie puhta kinnitus on vale. Palun sisestage kinnituskastes sõna "DELETE".',
        'success'               => 'Kustutatud andmed on edukalt puhastatud.',
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
