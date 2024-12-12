<?php

return [

    'undeployable' 		 => '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	 => 'Активът не съществува.',
    'does_not_exist_var' => 'Активът с етике :asset_tag не е намерен.',
    'no_tag' 	         => 'Не е предоставен етикет на актив.',
    'does_not_exist_or_not_requestable' => 'Актива не съществува или не може да бъде предоставян.',
    'assoc_users'	 	 => 'Активът е изписан на потребител и не може да бъде изтрит. Моля впишете го обратно и след това опитайте да го изтриете отново.',
    'warning_audit_date_mismatch' 	=> 'Следващата дата на одит на този актив (:next_audit_date) е преди последната дата на одит (:last_audit_date). Моля, актуализирайте следващата дата на одита.',
    'labels_generated'   => 'Labels were successfully generated.',
    'error_generating_labels' => 'Error while generating labels.',
    'no_assets_selected' => 'No assets selected.',

    'create' => [
        'error'   		=> 'Активът не беше създаден. Моля опитайте отново.',
        'success' 		=> 'Активът създаден успешно.',
        'success_linked' => 'Артикул с етикет :tag беше създаден успешно. <strong><a href=":link" style="color: white;">Щракнете тук за да го видите</a></strong>.',
        'multi_success_linked' => 'Asset with tag :links was created successfully.|:count assets were created succesfully. :links.',
        'partial_failure' => 'An asset was unable to be created. Reason: :failures|:count assets were unable to be created. Reasons: :failures',
    ],

    'update' => [
        'error'   			=> 'Активът не беше обновен. Моля опитайте отново.',
        'success' 			=> 'Активът обновен успешно.',
        'encrypted_warning' => 'Активът беше актуализиран успешно, но шифрованите персонализирани полета не бяха актуализирани поради разрешения',
        'nothing_updated'	=>  'Няма избрани полета, съответно нищо не беше обновено.',
        'no_assets_selected'  =>  'Няма избрани активи, така че нищо не бе обновено.',
        'assets_do_not_exist_or_are_invalid' => 'Избраните активи не могат да се обновят.',
    ],

    'restore' => [
        'error'   		=> 'Активът не беше възстановен. Моля опитайте отново.',
        'success' 		=> 'Активът възстановен успешно.',
        'bulk_success' 		=> 'Активът възстановен успешно.',
        'nothing_updated'   => 'Няма избрани активи, така че нищо не бе възстановено.', 
    ],

    'audit' => [
        'error'   		=> 'Одитът на активите е неуспешен: :error ',
        'success' 		=> 'Активният одит бе успешно регистриран.',
    ],


    'deletefile' => [
        'error'   => 'Файлът не беше изтрит. Моля опитайте отново.',
        'success' => 'Файлът изтрит успешно.',
    ],

    'upload' => [
        'error'   => 'Качването неуспешно. Моля опитайте отново.',
        'success' => 'Качването успешно.',
        'nofiles' => 'Не сте избрали файлове за качване или са твърде големи.',
        'invalidfiles' => 'Един или повече файлове са твърде големи или с непозволен тип. Разрешените файлови типове за качване са png, gif, jpg, doc, docx, pdf и txt.',
    ],

    'import' => [
        'import_button'         => 'Process Import',
        'error'                 => 'Някои елементи не бяха въведени правилно.',
        'errorDetail'           => 'Следните елементи не бяха въведени поради грешки.',
        'success'               => 'Вашият файл беше въведен.',
        'file_delete_success'   => 'Вашият файл беше изтрит успешно.',
        'file_delete_error'      => 'Файлът не е в състояние да бъде изтрит',
        'file_missing' => 'Избраният файл липсва',
        'file_already_deleted' => 'The file selected was already deleted',
        'header_row_has_malformed_characters' => 'Един или повече атрибути на заглавния ред съдържат неправилни UTF-8 символи',
        'content_row_has_malformed_characters' => 'Един или повече атрибути на заглавния ред съдържат неправилни UTF-8 символи',
    ],


    'delete' => [
        'confirm'   	=> 'Сигурни ли сте, че желаете изтриване на актива?',
        'error'   		=> 'Проблем при изтриване на актива. Моля опитайте отново.',
        'nothing_updated'   => 'Няма избрани активи, така че нищо не бе изтрито.',
        'success' 		=> 'Активът е изтрит успешно.',
    ],

    'checkout' => [
        'error'   		=> 'Активът не беше изписан. Моля опитайте отново.',
        'success' 		=> 'Активът изписан успешно.',
        'user_does_not_exist' => 'Невалиден потребител. Моля опитайте отново.',
        'not_available' => 'Този актив не е наличен за отписване!',
        'no_assets_selected' => 'Трябва да изберете поне един елемент към списъка',
    ],

    'multi-checkout' => [
        'error'   => 'Asset was not checked out, please try again|Assets were not checked out, please try again',
        'success' => 'Asset checked out successfully.|Assets checked out successfully.',
    ],

    'checkin' => [
        'error'   		=> 'Активът не беше вписан. Моля опитайте отново.',
        'success' 		=> 'Активът вписан успешно.',
        'user_does_not_exist' => 'Невалиден потребител. Моля опитайте отново.',
        'already_checked_in'  => 'Активът е вече вписан.',

    ],

    'requests' => [
        'error'   		=> 'Активът не беше изискан. Моля опитайте отново.',
        'success' 		=> 'Активът изискан успешно.',
        'canceled'      => 'Заявка за отписване отказана успешно',
    ],

];
