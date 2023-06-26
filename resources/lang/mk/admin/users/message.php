<?php

return array(

    'accepted'                  => 'Го прифативте основното средство.',
    'declined'                  => 'Го одбивте основното средство.',
    'bulk_manager_warn'	        => 'Вашите корисници се ажурирани, но записот за менаџерот не е зачуван, бидејќи менаџерот што го избравте беше во листата на корисници што се ажурираа. Корисниците не може да бидат свој сопствен менаџер. Изберете ги корисниците повторно, со исклучок на менаџерот и пробајте пак.',
    'user_exists'               => 'Корисникот веќе постои!',
    'user_not_found'            => 'User does not exist.',
    'user_login_required'       => 'Полето за корисничко име е задолжително',
    'user_password_required'    => 'Потребна е лозинка.',
    'insufficient_permissions'  => 'Недоволни дозволи.',
    'user_deleted_warning'      => 'Овој корисник е избришан. Ќе мора да го вратите за да го ажурирате или да му доделите нови основни средства.',
    'ldap_not_configured'        => 'Интеграција со LDAP не е конфигурирана.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',
    'user_has_no_assets_assigned'   => 'This user does not have any assets assigned',


    'success' => array(
        'create'    => 'Корисникот е креиран.',
        'update'    => 'Корисникот е ажуриран.',
        'update_bulk'    => 'Корисниците се ажурирани!',
        'delete'    => 'Корисникот е избришан.',
        'ban'       => 'Корисникот е блокиран.',
        'unban'     => 'Корисникот е одблокиран.',
        'suspend'   => 'Корисникот е привремено блокиран.',
        'unsuspend' => 'Привременото блокирање е отстрането.',
        'restored'  => 'Корисникот е вратен.',
        'import'    => 'Корисниците се увезени.',
    ),

    'error' => array(
        'create' => 'Имаше проблем со креирање на корисникот. Обидете се повторно.',
        'update' => 'Имаше проблем со ажурирање на корисникот. Обидете се повторно.',
        'delete' => 'Имаше проблем со бришење на корисникот. Обидете се повторно.',
        'delete_has_assets' => 'Корисникот има задолжени ставки и не може да биде избришан.',
        'unsuspend' => 'Имаше проблем со отстранување на привременото блокирање. Обидете се повторно.',
        'import'    => 'Имаше проблем со увозот на корисници. Обидете се повторно.',
        'asset_already_accepted' => 'Ова основно средство веќе е прифатено.',
        'accept_or_decline' => 'Мора да го прифатите или одбиете основното средство.',
        'incorrect_user_accepted' => 'Средството што се обидовте да го прифатите не е задожено на Вас.',
        'ldap_could_not_connect' => 'Не можам да се поврзам со LDAP серверот. Проверете ја конфигурацијата за LDAP сервер во LDAP конфигурациската датотека. <br>Грешка од LDAP-серверот:',
        'ldap_could_not_bind' => 'Не можам да се поврзам со LDAP серверот. Проверете ја конфигурацијата за LDAP сервер во LDAP конфигурациската датотека. <br>Грешка од LDAP-серверот: ',
        'ldap_could_not_search' => 'Не можам да го пребарам LDAP серверот. Проверете ја конфигурацијата за LDAP сервер во LDAP конфигурациската датотека. <br>Грешка од LDAP-серверот:',
        'ldap_could_not_get_entries' => 'Не можам да добијам записи од LDAP серверот. Проверете ја конфигурацијата за LDAP сервер во LDAP конфигурациската датотека. <br>Грешка од LDAP-серверот:',
        'password_ldap' => 'Лозинката за корисникот е управувана од LDAP/Active Directory. Ве молиме контактирајте го одделот за ИТ за да ја смените вашата лозинка. ',
    ),

    'deletefile' => array(
        'error'   => 'Датотеката не се избриша. Обидете се повторно.',
        'success' => 'Датотеката е избришана.',
    ),

    'upload' => array(
        'error'   => 'Датотеките не се прикачени. Обидете се повторно.',
        'success' => 'Датотеките се прикачени.',
        'nofiles' => 'Не одбравте датотеки за прикачување',
        'invalidfiles' => 'Една или повеќе од вашите датотеки е преголема или е тип на датотека што не е дозволен. Дозволени типови на датотеки се png, gif, jpg, doc, docx, pdf и txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'This user has no email set.',
        'success' => 'The user has been notified about their current inventory.'
    )
);