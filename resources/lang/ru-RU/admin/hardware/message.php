<?php

return [

    'undeployable' 		 => '<strong>Внимание: </strong> Этот актив в настоящее время помечен как не подлежащий установке. Если этот статус изменился, пожалуйста обновите статус актива.',
    'does_not_exist' 	 => 'Актив не существует.',
    'does_not_exist_var' => 'Актив с тегом :asset_tag не найден.',
    'no_tag' 	         => 'Тег актива не предоставлен.',
    'does_not_exist_or_not_requestable' => 'Этот актив не существует или не подлежит запросу.',
    'assoc_users'	 	 => 'Этот актив в настоящее время привязан к пользователю и не может быть удален. Пожалуйста сначала снимите привязку, и затем попробуйте удалить снова. ',
    'warning_audit_date_mismatch' 	=> 'Дата следующего аудита этого актива (:next_audit_date) не может быть раньше последней даты аудита (:last_audit_date). Пожалуйста, обновите следующую дату аудита.',
    'labels_generated'   => 'Labels were successfully generated.',
    'error_generating_labels' => 'Error while generating labels.',
    'no_assets_selected' => 'No assets selected.',

    'create' => [
        'error'   		=> 'Актив не был создан, пожалуйста попробуйте снова. :(',
        'success' 		=> 'Актив успешно создан. :)',
        'success_linked' => 'Актив с тегом :tag успешно создан. <strong><a href=":link" style="color: white;">Нажмите для просмотра</a></strong>.',
        'multi_success_linked' => 'Asset with tag :links was created successfully.|:count assets were created succesfully. :links.',
        'partial_failure' => 'An asset was unable to be created. Reason: :failures|:count assets were unable to be created. Reasons: :failures',
    ],

    'update' => [
        'error'   			=> 'Актив не был изменен, пожалуйста попробуйте снова',
        'success' 			=> 'Актив успешно изменен.',
        'encrypted_warning' => 'Актив обновлен успешно, но зашифрованные пользовательские поля не были из-за разрешений',
        'nothing_updated'	=>  'Поля не выбраны, нечего обновлять.',
        'no_assets_selected'  =>  'Никакие ресурсы не были выбраны, поэтому ничего не обновлялось.',
        'assets_do_not_exist_or_are_invalid' => 'Выбранные медиафайлы не могут быть обновлены.',
    ],

    'restore' => [
        'error'   		=> 'Актив не был восстановлен, повторите попытку',
        'success' 		=> 'Актив успешно восстановлен.',
        'bulk_success' 		=> 'Актив успешно восстановлен.',
        'nothing_updated'   => 'Ни один из активов не выбран, поэтому ничего не восстановлено.', 
    ],

    'audit' => [
        'error'   		=> 'Аудит активов не удался: :error ',
        'success' 		=> 'Аудит успешно выполнен.',
    ],


    'deletefile' => [
        'error'   => 'Не удалось удалить файл. Повторите попытку.',
        'success' => 'Файл успешно удален.',
    ],

    'upload' => [
        'error'   => 'Не удалось загрузить файл(ы). Повторите попытку.',
        'success' => 'Файл(ы) успешно загружены.',
        'nofiles' => 'Не выбрано ни одного файла для загрузки или файл, который вы пытаетесь загрузить, слишком большой',
        'invalidfiles' => 'Один или несколько ваших файлов слишком большого размера или имеют неподдерживаемый формат. Разрешены только следующие форматы файлов:  png, gif, jpg, doc, docx, pdf, txt.',
    ],

    'import' => [
        'import_button'         => 'Процесс Импорта',
        'error'                 => 'Некоторые элементы не были импортированы корректно.',
        'errorDetail'           => 'Следующие элементы не были импортированы из за ошибок.',
        'success'               => 'Ваш файл был импортирован',
        'file_delete_success'   => 'Ваш файл был успешно удален',
        'file_delete_error'      => 'Невозможно удалить файл',
        'file_missing' => 'Выбранный файл отсутствует',
        'file_already_deleted' => 'Выбранный файл уже удален',
        'header_row_has_malformed_characters' => 'Один или несколько атрибутов в строке заголовка содержат неправильно сформированные символы UTF-8',
        'content_row_has_malformed_characters' => 'Один или несколько атрибутов в первой строке содержимого содержат неправильно сформированные символы UTF-8',
    ],


    'delete' => [
        'confirm'   	=> 'Вы уверены что хотите удалить этот актив?',
        'error'   		=> 'При удалении актива возникла проблема. Пожалуйста попробуйте снова.',
        'nothing_updated'   => 'Ни один из активов не выбран, поэтому ничего не удалено.',
        'success' 		=> 'Актив был успешно удален.',
    ],

    'checkout' => [
        'error'   		=> 'Актив не был привязан, пожалуйста попробуйте снова',
        'success' 		=> 'Актив успешно привязан.',
        'user_does_not_exist' => 'Этот пользователь является недопустимым. Пожалуйста, попробуйте еще раз.',
        'not_available' => 'Данный актив недоступен к выдаче!',
        'no_assets_selected' => 'Вы должны выбрать хотя бы один актив из списка',
    ],

    'multi-checkout' => [
        'error'   => 'Asset was not checked out, please try again|Assets were not checked out, please try again',
        'success' => 'Asset checked out successfully.|Assets checked out successfully.',
    ],

    'checkin' => [
        'error'   		=> 'Актив не был отвязан, пожалуйста попробуйте снова',
        'success' 		=> 'Актив успешно отвязан.',
        'user_does_not_exist' => 'Этот пользователь является недопустимым. Пожалуйста, попробуйте еще раз.',
        'already_checked_in'  => 'Этот актив уже привязан.',

    ],

    'requests' => [
        'error'   		=> 'Актив не был запрошен, попробуйте ещё раз',
        'success' 		=> 'Актив запрошен успешно.',
        'canceled'      => 'Запрос актива успешно отменен',
    ],

];
