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
        'restore_warning'       => 'Да, восстановить. Я осознаю, что это перезапишет все существующие данные в базе данных. Это также выйдет из учетных записей всех ваших существующих пользователей (включая вас).',
        'restore_confirm'       => 'Вы уверены, что хотите восстановить базу данных из :filename?'
    ],
    'purge' => [
        'error'     => 'Возникла ошибка при попытке очистки. ',
        'validation_failed'     => 'Ваш текст подтверждения очистки неверен. Пожалуйста, наберите слово "DELETE" в поле подтверждения.',
        'success'               => 'Удаленные записи успешно очищены.',
    ],
    'mail' => [
        'sending' => 'Отправляется тестовое электронное письмо...',
        'success' => 'Письмо отправлено!',
        'error' => 'Не удалось отправить электронное письмо.',
        'additional' => 'Нет дополнительных сообщений об ошибке. Проверьте настройки почты и журнал вашего приложения.'
    ],
    'ldap' => [
        'testing' => 'Тестирование подключения к LDAP, привязка & запрос ...',
        '500' => 'Ошибка в 500 сервере. Пожалуйста, проверьте журналы сервера для получения дополнительной информации.',
        'error' => 'Что-то пошло не так :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Тестирование LDAP аутентификации...',
        'authentication_success' => 'Пользователь успешно аутентифицирован с LDAP!'
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
