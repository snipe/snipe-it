<?php

return [

    'update' => [
        'error'                 => 'Med posodabljanjem je prišlo do napake. ',
        'success'               => 'Nastavitve so bile posodobljene uspešno.',
    ],
    'backup' => [
        'delete_confirm'        => 'Ali ste prepričani, da želite izbrisati to varnostno datoteko? To dejanje ni mogoče razveljaviti. ',
        'file_deleted'          => 'Varnostna datoteka je bila uspešno izbrisana. ',
        'generated'             => 'Ustvarjena je bila nova varnostna kopija.',
        'file_not_found'        => 'To varnostno datoteko ni bilo mogoče najti na strežniku.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Pri čiščenju je prišlo do napake. ',
        'validation_failed'     => 'Vaša potrditev čiščenja je napačna. V polje za potrditev vnesite besedo »DELETE«.',
        'success'               => 'Izbrisani zapisi so bili uspešno počiščeni.',
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
