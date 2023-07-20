<?php

return [
    'about_assets_title'           => 'Относно активи',
    'about_assets_text'            => 'Активите са елементи, проследен от сериен номер или етикет. По-често, те са елементи с висока стойност, където идентифицирането на специфичен елемент е от значение.',
    'archived'  				=> 'Архивиран',
    'asset'  					=> 'Актив',
    'bulk_checkout'             => 'Изписване на активи',
    'bulk_checkin'              => 'Връщане на актив',
    'checkin'  					=> 'Връщане на актив',
    'checkout'  				=> 'Проверка на активите',
    'clone'  					=> 'Копиране на актив',
    'deployable'  				=> 'Може да бъде предоставен',
    'deleted'  					=> 'Този актив беше изтрит.',
    'edit'  					=> 'Редакция на актив',
    'model_deleted'  			=> 'Този Модел на актив беше изтрит. Вие трябва да възстановите този модел преди да можете да възстановите актива.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Може да бъде изискван',
    'requested'				    => 'Изискан',
    'not_requestable'           => 'Не може да бъде изискан',
    'requestable_status_warning' => 'Да не се сменя статуса за изискване',
    'restore'  					=> 'Възстановяване на актив',
    'pending'  					=> 'Предстоящ',
    'undeployable'  			=> 'Не може да бъде предоставян',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Преглед на актив',
    'csv_error' => 'Имате грешка във вашият CSV файл:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Try to match users by firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Try to match users by email as username',
    'csv_import_match_username' => 'Try to match users by username',
    'error_messages' => 'Съобщение за грешка:',
    'success_messages' => 'Success messages:',
    'alert_details' => 'Please see below for details.',
    'custom_export' => 'Custom Export',
    'mfg_warranty_lookup' => ':manufacturer Warranty Status Lookup',
];
