<?php

return array(

    'accepted'                  => 'Вы успешно приняли актив.',
    'declined'                  => 'Вы успешно отклонили актив.',
    'user_exists'               => 'Пользователь уже существует!',
    'user_not_found'            => 'Пользователь [:id] не существует.',
    'user_login_required'       => 'Поле "Логин" является обязательным',
    'user_password_required'    => 'Поле "Пароль" является обязательным.',
    'insufficient_permissions'  => 'Недостаточно прав.',
    'user_deleted_warning'      => 'Этот пользователь был удален. Вы должны его восстановить чтобы иметь возможность его редактировать или привязывать новые активы.',
    'ldap_not_configured'        => 'Интеграция с LDAP не настроена для этой инсталляции.',


    'success' => array(
        'create'    => 'Пользователь успешно создан.',
        'update'    => 'Пользователь успешно изменен.',
        'delete'    => 'Пользователь успешно удален.',
        'ban'       => 'Пользователь успешно заблокирован.',
        'unban'     => 'Пользователь успешно разблокирован.',
        'suspend'   => 'Пользователь успешно заморожен.',
        'unsuspend' => 'Пользователь успешно разморожен.',
        'restored'  => 'Пользователь успешно восстановлен.',
        'import'    => 'Пользователи успешно импортированы.',
    ),

    'error' => array(
        'create' => 'При создании пользователя возникла проблема. Пожалуйста попробуйте снова.',
        'update' => 'При изменении пользователя возникла проблема. Пожалуйста попробуйте снова.',
        'delete' => 'При удалении пользователя возникла проблема. Пожалуйста попробуйте снова.',
        'unsuspend' => 'При разморозке пользователя возникла проблема. Пожалуйста попробуйте снова.',
        'import'    => 'При импорте пользователей произошла ошибка. Попробуйте еще раз.',
        'asset_already_accepted' => 'Этот актив уже был принят.',
        'accept_or_decline' => 'Примите или отклоните актив.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
    ),

    'deletefile' => array(
        'error'   => 'Не удалось удалить файл. Повторите попытку.',
        'success' => 'Файл успешно удален.',
    ),

    'upload' => array(
        'error'   => 'Не удалось загрузить файл(ы). Повторите попытку.',
        'success' => 'Файл(ы) успешно загружены.',
        'nofiles' => 'Не выбраны файлы для загрузки',
        'invalidfiles' => 'Один или несколько ваших файлов слишком большого размера или имеют неподдерживаемый формат. Разрешены только следующие форматы файлов: png, gif, jpg, doc, docx, pdf, txt.',
    ),

);
