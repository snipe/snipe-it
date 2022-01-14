<?php

return [

    'update' => [
        'error'                 => 'A aparut o eroare la actualizare. ',
        'success'               => 'Setari au fost actualizate.',
    ],
    'backup' => [
        'delete_confirm'        => 'Sigur doriți să ștergeți acest fișier de rezervă? Această acțiune nu poate fi anulată.',
        'file_deleted'          => 'Fișierul de rezervă a fost șters cu succes.',
        'generated'             => 'Un nou dosar de rezervă a fost creat cu succes.',
        'file_not_found'        => 'Acest fișier de rezervă nu a putut fi găsit pe server.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'A apărut o eroare în timpul epurării.',
        'validation_failed'     => 'Confirmarea dvs. de purjare este incorectă. Introduceți cuvântul "DELETE" în caseta de confirmare.',
        'success'               => 'Înregistrările șterse au fost eliminate cu succes.',
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
