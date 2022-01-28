<?php

return [

    'update' => [
        'error'                 => 'Tharla earráid agus é ag nuashonrú.',
        'success'               => 'Nuashonraigh na socruithe go rathúil.',
    ],
    'backup' => [
        'delete_confirm'        => 'An bhfuil tú cinnte gur mhaith leat an comhad cúltaca seo a scriosadh? Ní féidir an gníomh seo a dhíbirt.',
        'file_deleted'          => 'Scriosadh an comhad cúltaca go rathúil.',
        'generated'             => 'Rinneadh comhad cúltaca nua a chruthú go rathúil.',
        'file_not_found'        => 'Níorbh fhéidir an comhad cúltaca sin a fháil ar an bhfreastalaí.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Tharla earráid agus í ag puráil.',
        'validation_failed'     => 'Tá do dheimhniú purge mícheart. Scríobh an focal "DELETE" sa bhosca daingnithe.',
        'success'               => 'Taifid arna scriosadh go rathúil.',
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
