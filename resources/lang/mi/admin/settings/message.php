<?php

return [

    'update' => [
        'error'                 => 'I puta he hapa i te whakahou.',
        'success'               => 'Kua whakahoutia nga tautuhinga.',
    ],
    'backup' => [
        'delete_confirm'        => 'Kei te hiahia koe ki te muku i tenei kōnae taapiri? Kaore e taea te whakakore tenei mahi.',
        'file_deleted'          => 'Kua mukua te kōnae taapiri.',
        'generated'             => 'He pai te waihanga i tetahi kōnae taapiri hou.',
        'file_not_found'        => 'Kāore i kitea te kōnae taapiri i runga i te tūmau.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Kua puta he hapa i te wa e purea ana.',
        'validation_failed'     => 'He hē te whakauru o te purge. Tena koa tuhia te kupu "MOTORI" i roto i te pouaka whakauru.',
        'success'               => 'I horoia nga tuhinga kua mukua.',
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
