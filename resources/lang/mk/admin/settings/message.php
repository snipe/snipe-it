<?php

return [

    'update' => [
        'error'                 => 'Се случи грешка при ажурирањето. ',
        'success'               => 'Поставките се ажурирани.',
    ],
    'backup' => [
        'delete_confirm'        => 'Дали си сигурен дека сакаш да ја избришеш резервната копија? Ова не може да биде вратено. ',
        'file_deleted'          => 'Резервната копија е избришана. ',
        'generated'             => 'Направена е нова резервна копија.',
        'file_not_found'        => 'Таа резервна копија не може да се најде на серверот.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Се случи грешка при трајното бришење. ',
        'validation_failed'     => 'Потврдата за трајно бришење е неточна. Внесете го зборот "DELETE" во полето за потврда.',
        'success'               => 'Записите се трајно избришани.',
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
