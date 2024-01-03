<?php

return array(

    'support_url_help' => 'Variables <code>{LOCALE}</code>, <code>{SERIAL}</code>, <code>{MODEL_NUMBER}</code>, and <code>{MODEL_NAME}</code> may be used in your URL to have those values auto-populate when viewing assets - for example https://support.apple.com/{LOCALE}/{SERIAL}.',
    'does_not_exist' => 'Виробник не існує.',
    'assoc_users'	 => 'This manufacturer is currently associated with at least one model and cannot be deleted. Please update your models to no longer reference this manufacturer and try again. ',

    'create' => array(
        'error'   => 'Manufacturer was not created, please try again.',
        'success' => 'Виробник успішно створений.'
    ),

    'update' => array(
        'error'   => 'Manufacturer was not updated, please try again',
        'success' => 'Виробника успішно оновлено.'
    ),

    'restore' => array(
        'error'   => 'Manufacturer was not restored, please try again',
        'success' => 'Manufacturer restored successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Ви впевнені що хочете видалити виробника?',
        'error'   => 'There was an issue deleting the manufacturer. Please try again.',
        'success' => 'Виробник успішно видалений.'
    )

);
