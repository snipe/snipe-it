<?php

return [

    'update' => [
        'error'                 => 'Počas upravovania sa vyskytla chyba. ',
        'success'               => 'Nastavenia boli úspešne upravené.',
    ],
    'backup' => [
        'delete_confirm'        => 'Ste si istý, že chcete odstrániť tento súbor so zálohou? Táto akcia sa nedá vrátiť. ',
        'file_deleted'          => 'Súbor so zálohou bol úspešne odstránený. ',
        'generated'             => 'Nový súbor so zálohou bol úspešne vytvorený.',
        'file_not_found'        => 'Súbor so zálohou sa nepodarilo nájsť na serveri.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Počas čistenia sa vyskytla chyba. ',
        'validation_failed'     => 'Potvrdenie odstránenia nie je správne. Prosím napíšte slovo "DELETE" do políčka na potvrdenie.',
        'success'               => 'Odstránené záznamy boli úspešne očistené.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Email odoslaný!',
        'error' => 'Email sa nepodarilo odoslať.',
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
