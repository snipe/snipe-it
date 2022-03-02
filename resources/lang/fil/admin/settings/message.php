<?php

return [

    'update' => [
        'error'                 => 'May naganap na error habang nag-update. ',
        'success'               => 'Matagumpay na nai-update ang mga setting.',
    ],
    'backup' => [
        'delete_confirm'        => 'Sigurado kaba na gusto mong i-delete ang back-up file na ito? Ang aksyong ito ay hindi pwedeng maibalik. ',
        'file_deleted'          => 'Ang back-up file ay matagumpay na nai-delete. ',
        'generated'             => 'Ang bagong back-up file ay matagumpay na nai-sagawa.',
        'file_not_found'        => 'Ang back-up file na iyon ay hindi makita sa serber.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Ang error ay nagyari habang nag-purge. ',
        'validation_failed'     => 'Ang iyong kompermasyon sa purge ay hindi tama. Mangyaring i-type ang salitang "DELETE" sa confirmation box.',
        'success'               => 'Matagumpay na nai-purge ang nai-delete na rekords.',
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
