<?php

return [

    'update' => [
        'error'                 => 'При обновлении произошла ошибка. ',
        'success'               => 'Настройки успешно обновлены.',
    ],
    'backup' => [
        'delete_confirm'        => 'Вы уверены, что хотите удалить резервную копию? Это действие нельзя отменить. ',
        'file_deleted'          => 'Резервная копия успешно удалена. ',
        'generated'             => 'Новая резервная копия успешно создана.',
        'file_not_found'        => 'Эта резервная копия не найдена на сервере.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Возникла ошибка при попытке очистки. ',
        'validation_failed'     => 'Ваш текст подтверждения очистки неверен. Пожалуйста, наберите слово "DELETE" в поле подтверждения.',
        'success'               => 'Удаленные записи успешно очищены.',
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
