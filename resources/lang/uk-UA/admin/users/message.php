<?php

return array(

    'accepted'                  => 'Ви успішно прийняли цей актив.',
    'declined'                  => 'Ви успішно відхилили цей актив.',
    'bulk_manager_warn'	        => 'Ваші користувачі успішно оновлені, однак Ваш запис менеджера не було збережено, оскільки обраний вами менеджер також був у списку користувачів, для редагування, і користувачі можуть не бути їх власним керівником. Будь ласка, оберіть ваших користувачів знову, не маючи менеджера.',
    'user_exists'               => 'Користувач вже існує!',
    'user_not_found'            => 'Користувач не існує.',
    'user_login_required'       => 'Поле авторизації є обов\'язковим',
    'user_has_no_assets_assigned' => 'Немає медіафайлів в даний час призначених користувачеві.',
    'user_password_required'    => 'Пароль є обов\'язковим.',
    'insufficient_permissions'  => 'Недостатньо прав.',
    'user_deleted_warning'      => 'Цей користувач був видалений. Вам доведеться відновити цього користувача, щоб відредагувати його або призначити йому нові активи.',
    'ldap_not_configured'        => 'Для цього встановлення інтеграція з LDAP не була налаштована.',
    'password_resets_sent'      => 'Вибрані користувачі, що активовані та дійсні електронні адреси, були відправлені на посилання для відновлення пароля.',
    'password_reset_sent'       => 'Посилання для зміни пароля було надіслано на :email!',
    'user_has_no_email'         => 'Цей користувач не має електронної пошти у своєму профілі.',
    'log_record_not_found'        => 'Відповідний запис журналу для цього користувача не знайдено.',


    'success' => array(
        'create'    => 'Користувача було успішно створено.',
        'update'    => 'Користувача було успішно оновлено.',
        'update_bulk'    => 'Користувачі були успішно оновлені!',
        'delete'    => 'Користувача успішно вилучено.',
        'ban'       => 'Користувач був успішно заблокований.',
        'unban'     => 'Користувач був успішно розблокований.',
        'suspend'   => 'Користувача успішно призупинено.',
        'unsuspend' => 'Користувача успішно скасувати призупинено.',
        'restored'  => 'Користувач був успішно відновлений.',
        'import'    => 'Користувачів успішно імпортовано.',
    ),

    'error' => array(
        'create' => 'Сталася помилка при створенні користувача. Будь ласка, спробуйте ще раз.',
        'update' => 'Виникла проблема при оновленні користувача. Будь ласка, спробуйте ще раз.',
        'delete' => 'Виникла проблема при видаленні користувача. Будь ласка, спробуйте ще раз.',
        'delete_has_assets' => 'Цей користувач має призначені елементи і не може бути видалений.',
        'delete_has_assets_var' => 'This user still has an asset assigned. Please check it in first.|This user still has :count assets assigned. Please check their assets in first.',
        'delete_has_licenses_var' => 'This user still has a license seats assigned. Please check it in first.|This user still has :count license seats assigned. Please check them in first.',
        'delete_has_accessories_var' => 'This user still has an accessory assigned. Please check it in first.|This user still has :count accessories assigned. Please check their assets in first.',
        'delete_has_locations_var' => 'This user still manages a location. Please select another manager first.|This user still manages :count locations. Please select another manager first.',
        'delete_has_users_var' => 'This user still manages another user. Please select another manager for that user first.|This user still manages :count users. Please select another manager for them first.',
        'unsuspend' => 'Виникла проблема не призупинення користувача. Будь ласка, спробуйте ще раз.',
        'import'    => 'Виникла проблема з імпортом користувачів. Будь ласка, спробуйте ще раз.',
        'asset_already_accepted' => 'Цей актив уже було прийнято.',
        'accept_or_decline' => 'Ви повинні прийняти або відхилити цей актив.',
        'cannot_delete_yourself' => 'We would feel really bad if you deleted yourself, please reconsider.',
        'incorrect_user_accepted' => 'Актив, який ви намагалися прийняти, не був перевірений для вас.',
        'ldap_could_not_connect' => 'Не вдалося підключитися до сервера LDAP. Будь ласка, перевірте конфігурацію вашого сервера LDAP у файлі конфігурації LDAP. <br>Помилка від LDAP Сервера:',
        'ldap_could_not_bind' => 'Не вдалося підключитися до сервера LDAP. Перевірте конфігурацію сервера LDAP у файлі конфігурації LDAP. <br>Помилка сервера LDAP: ',
        'ldap_could_not_search' => 'Не вдалося знайти сервер LDAP. Будь ласка, перевірте конфігурацію сервера LDAP в файлі конфігурації LDAP. <br>Помилка від LDAP Server:',
        'ldap_could_not_get_entries' => 'Не вдалося отримати записи з сервера LDAP. Перевірте конфігурацію сервера LDAP у файлі конфігурації LDAP. <br>Помилка сервера LDAP:',
        'password_ldap' => 'Пароль для цього облікового запису керується LDAP/Active Directory. Зверніться до свого ІТ-відділу, щоб змінити пароль. ',
    ),

    'deletefile' => array(
        'error'   => 'Файл не видалено. Будь ласка, спробуйте ще раз.',
        'success' => 'Файл успішно видалено.',
    ),

    'upload' => array(
        'error'   => 'Файл(и) не завантажено. Повторіть спробу.',
        'success' => 'Файл(и) успішно завантажено.',
        'nofiles' => 'Ви не вибрали жодного файлу для завантаження',
        'invalidfiles' => 'Один або кілька ваших файлів завеликий або є файловим типом, який не допускається. Дозволені типи файлів - png, gif, jpg, doc, docx, pdf, і txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'Цей користувач не має встановленої електронної пошти.',
        'success' => 'Користувач був повідомлений про їх поточний інвентар.'
    )
);