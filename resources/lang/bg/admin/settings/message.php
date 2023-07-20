<?php

return [

    'update' => [
        'error'                 => 'Възникна грешка по време на актуализацията. ',
        'success'               => 'Настройките са актуализирани успешно.',
    ],
    'backup' => [
        'delete_confirm'        => 'Желаете ли изтриването на този архивен файл? Действието е окончателно.',
        'file_deleted'          => 'Архивният файл беше изтрит успешно.',
        'generated'             => 'Нов архивен файл беше създаден успешно.',
        'file_not_found'        => 'Архивният файл не беше открит на сървъра.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Възникна грешка при пречистване. ',
        'validation_failed'     => 'Потвърждението ви за пречистване не неправилно. Моля напишете думата "DELETE" в клетката за потвърждаване.',
        'success'               => 'Изтрити записи успешно премахнати.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => 'Грешка 500. Моля проверете логовете на сървъра за повече информация.',
        'error' => 'Възникна грешка :(',
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
