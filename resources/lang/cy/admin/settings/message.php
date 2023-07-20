<?php

return [

    'update' => [
        'error'                 => 'Gwall wedi digwydd wrth diweddaru. ',
        'success'               => 'Gosodiadau wedi diweddaru\'n llwyddiannus.',
    ],
    'backup' => [
        'delete_confirm'        => 'Ydych yn dymuno dileu y ffeil copi wrth gefn yma? Nid oes modd adfer ar ol dileu. ',
        'file_deleted'          => 'Wedi llwydo i ddileu y ffeil copi wrth gefn. ',
        'generated'             => 'Wedi llwyddo i greu ffeil copi wrth gefn.',
        'file_not_found'        => 'Wedi methu darganfod y ffeil copi wrth gefn ar y server.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Gwall wedi digwydd wrth glirio. ',
        'validation_failed'     => 'Mae eich cadarnhad i clirio yn anghywir. Teipiwch y gair "DELETE" yn y bocs cadarnhad.',
        'success'               => 'Cofnodion wedi clirio\'n llwyddiannus.',
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
