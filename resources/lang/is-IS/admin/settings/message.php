<?php

return [

    'update' => [
        'error'                 => 'An error has occurred while updating. ',
        'success'               => 'Settings updated successfully.',
    ],
    'backup' => [
        'delete_confirm'        => 'Are you sure you would like to delete this backup file? This action cannot be undone. ',
        'file_deleted'          => 'Öryggisafritaskránni var eytt. ',
        'generated'             => 'Ný öryggisafritaskrá var búin til.',
        'file_not_found'        => 'Þessi öryggisafritaskrá finnst ekki á vefþjóninum.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'restore' => [
        'success'               => 'Your system backup has been restored. Please log in again.'
    ],
    'purge' => [
        'error'     => 'An error has occurred while purging. ',
        'validation_failed'     => 'Your purge confirmation is incorrect. Please type the word "DELETE" in the confirmation box.',
        'success'               => 'Deleted records successfully purged.',
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
        'error' => 'Eitthvað fór úrskeiðis :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Prófa LDAP auðkenningu...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'labels' => [
        'null_template' => 'Label template not found. Please select a template.',
        ],
    'webhook' => [
        'sending' => 'Sending :app test message...',
        'success' => 'Your :webhook_name Integration works!',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. :app responded with: :error_message',
        'error_redirect' => 'ERROR: 301/302 :endpoint returns a redirect. For security reasons, we don’t follow redirects. Please use the actual endpoint.',
        'error_misc' => 'Eitthvað fór úrskeiðis. :( ',
        'webhook_fail' => ' webhook notification failed: Check to make sure the URL is still valid.',
        'webhook_channel_not_found' => ' webhook channel not found.'
    ]
];
