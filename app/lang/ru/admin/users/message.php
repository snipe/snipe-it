<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Пользователь уже существует!',
    'user_not_found'            => 'Пользователь [:id] не существует.',
    'user_login_required'       => 'Поле "Логин" является обязательным',
    'user_password_required'    => 'Поле "Пароль" является обязательным.',
    'insufficient_permissions'  => 'Недостаточно прав.',
    'user_deleted_warning'      => 'Этот пользователь был удален. Вы должны его восстановить чтобы иметь возможность его редактировать или привязывать новые активы.',


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
        'accept_or_decline' => 'You must either accept or decline this asset.',
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);
