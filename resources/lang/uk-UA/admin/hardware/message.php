<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Медіафайл не існує.',
    'does_not_exist_var'=> 'Asset with tag :asset_tag not found.',
    'no_tag' 	        => 'No asset tag provided.',
    'does_not_exist_or_not_requestable' => 'Цей актив не існує або його не можна запитувати.',
    'assoc_users'	 	=> 'Цей актив в даний час відмічений користувачу і не може бути видалений. Спочатку перевірте активи, а потім спробуйте видалити знову. ',
    'warning_audit_date_mismatch' 	=> 'This asset\'s next audit date (:next_audit_date) is before the last audit date (:last_audit_date). Please update the next audit date.',

    'create' => [
        'error'   		=> 'Актив не був створений, будь ласка, спробуйте ще раз :(',
        'success' 		=> 'Актив успішно створений. :)',
        'success_linked' => 'Активу з тегом :tag було успішно створено. <strong><a href=":link" style="color: white;">Натисніть тут, щоб переглянути</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Актив не був оновлений, будь ласка, спробуйте ще раз',
        'success' 			=> 'Актив успішно оновлено.',
        'encrypted_warning' => 'Актив успішно оновлений, але зашифровані користувальницькі поля не були із-за дозволів',
        'nothing_updated'	=>  'Не було обрано жодного поля, тому нічого не було оновлено.',
        'no_assets_selected'  =>  'Не було обрано медіафайли, тому нічого не було змінено.',
        'assets_do_not_exist_or_are_invalid' => 'Вибрані медіафайли не можуть бути оновлені.',
    ],

    'restore' => [
        'error'   		=> 'Актив не був відновлений, будь ласка, спробуйте ще раз',
        'success' 		=> 'Актив успішно відновлено.',
        'bulk_success' 		=> 'Актив успішно відновлено.',
        'nothing_updated'   => 'Медіафайли не були вибрані, тому нічого не було відновлено.', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit unsuccessful: :error ',
        'success' 		=> 'Активу успішно зараховано журнал.',
    ],


    'deletefile' => [
        'error'   => 'Файл не видалено. Будь ласка, спробуйте ще раз.',
        'success' => 'Файл успішно видалено.',
    ],

    'upload' => [
        'error'   => 'Файл(и) не завантажено. Повторіть спробу.',
        'success' => 'Файл(и) успішно завантажено.',
        'nofiles' => 'Ви не обрали жодного файлу для завантаження, або завеликий файл',
        'invalidfiles' => 'Один або кілька ваших файлів завеликий або є файловим типом, який не допускається. Дозволені типи файлів - png, gif, jpg, doc, docx, pdf, і txt.',
    ],

    'import' => [
        'import_button'         => 'Process Import',
        'error'                 => 'Деякі елементи не імпортовано належним чином.',
        'errorDetail'           => 'Наступні елементи не були імпортовані через помилки.',
        'success'               => 'Ваш файл імпортовано',
        'file_delete_success'   => 'Ваш файл успішно вилучено',
        'file_delete_error'      => 'Файл не може бути видалений',
        'file_missing' => 'Відсутній файл',
        'header_row_has_malformed_characters' => 'Один або кілька атрибутів у рядку заголовка містять невірні символи UTF-8',
        'content_row_has_malformed_characters' => 'Один або кілька атрибутів у першому рядку вмісту містять неправильні символи UTF-8',
    ],


    'delete' => [
        'confirm'   	=> 'Ви впевнені, що хочете видалити цей медіафайл?',
        'error'   		=> 'Виникла проблема при видаленні активу. Будь ласка, спробуйте ще раз.',
        'nothing_updated'   => 'Активи не були вибрані, тому нічого не було видалено.',
        'success' 		=> 'Актив успішно видалений.',
    ],

    'checkout' => [
        'error'   		=> 'Актив не був перевірений, будь ласка, спробуйте ще раз',
        'success' 		=> 'Актив успішно перевірено.',
        'user_does_not_exist' => 'Невірний користувач. Спробуйте ще раз.',
        'not_available' => 'Цей актив недоступний для оформлення!',
        'no_assets_selected' => 'Ви повинні вибрати хоча б один медіафайл зі списку',
    ],

    'checkin' => [
        'error'   		=> 'Актив не був перевірений, будь ласка, спробуйте ще раз',
        'success' 		=> 'Актив успішно перевірено.',
        'user_does_not_exist' => 'Вказаного користувача не існує. Спробуйте ще раз.',
        'already_checked_in'  => 'Цей актив вже перевіряється.',

    ],

    'requests' => [
        'error'   		=> 'Актив не був запитаний, будь ласка, спробуйте ще раз',
        'success' 		=> 'Актив успішно запитаний.',
        'canceled'      => 'Запит на оформлення замовлення успішно скасовано',
    ],

];
