<?php

return array(

    'accepted'                  => 'Активът беше приет.',
    'declined'                  => 'Активът беше отказан.',
    'user_exists'               => 'Потребителят вече съществува!',
    'user_not_found'            => 'Потребител [:id] не съществува.',
    'user_login_required'       => 'Полето за вход е задължително',
    'user_password_required'    => 'Паролата е задължителна.',
    'insufficient_permissions'  => 'Нямате необходимите права.',
    'user_deleted_warning'      => 'Този потребител е изтрит. За да редактирате данните за него или да му зададете актив, трябва първо да възстановите потребителя.',
    'ldap_not_configured'        => 'Интеграцията с LDAP не е конфигурирана за тази инсталация.',


    'success' => array(
        'create'    => 'Потребителят е създаден.',
        'update'    => 'Потребителят е обновен.',
        'delete'    => 'Потребителят е изтрит.',
        'ban'       => 'User was successfully banned.',
        'unban'     => 'User was successfully unbanned.',
        'suspend'   => 'User was successfully suspended.',
        'unsuspend' => 'User was successfully unsuspended.',
        'restored'  => 'Потребителят е възстановен.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'Възникна проблем при създаването на този потребител. Моля, опитайте отново.',
        'update' => 'Възникна проблем при обновяването на този потребител. Моля, опитайте отново.',
        'delete' => 'Възникна проблем при изтриването на този потребител. Моля, опитайте отново.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'import'    => 'There was an issue importing users. Please try again.',
        'asset_already_accepted' => 'Този актив е вече приет.',
        'accept_or_decline' => 'Трябва да приемете или да откажете този актив.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
    ),

    'deletefile' => array(
        'error'   => 'Файлът не е изтрит. Моля, опитайте отново.',
        'success' => 'Файлът е изтрит.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);
