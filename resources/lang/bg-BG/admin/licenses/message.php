<?php

return [

    'does_not_exist' => 'Лиценза не съществува или нямата права да го видите.',
    'user_does_not_exist' => 'Потребителят не съществува или нямате разрешение да го видите.',
    'asset_does_not_exist' => 'Активът, който се опитвате да свържете с този лиценз не съществува.',
    'owner_doesnt_match_asset' => 'Активът, който се опитвате да свържете с този лиценз е притежание на друго лице, различно от това, което е определено в падащия списък.',
    'assoc_users' => 'Този лиценз понастоящем е изписан на потребител и не може да бъде изтрит. Моля, първо впишете лиценза и тогава опитайте отново да го изтриете. ',
    'select_asset_or_person' => 'Трябва да изберете актив или потребител, но не и двете.',
    'not_found' => 'Лиценът не е намерен',
    'seats_available' => ':seat_count места са налични',

    'create' => [
        'error' => 'Лицензът не беше създаден. Моля, опитайте отново.',
        'success' => 'Лицензът е създаден.',
    ],

    'deletefile' => [
        'error' => 'Файлът не е изтрит. Моля, опитайте отново.',
        'success' => 'Файлът е изтрит.',
    ],

    'upload' => [
        'error' => 'Файлът (файловете) не е качен. Моля, опитайте отново.',
        'success' => 'Файлът (файловете) е качен.',
        'nofiles' => 'Не сте избрали файл за качване или файлът, който се опитвате да качите е твърде голям',
        'invalidfiles' => 'Един или повече от вашите файлове е твърде голям или е забранен тип файл. Разрешените типове файл са png, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml, и lic.',
    ],

    'update' => [
        'error' => 'Лицензът не беше обновен. Моля, опитайте отново',
        'success' => 'Лицензът е обновен.',
    ],

    'delete' => [
        'confirm' => 'Сигурни ли сте, че искате да изтриете този лиценз?',
        'error' => 'Възникна проблем при изтриването на този лиценз. Моля, опитайте отново.',
        'success' => 'Лицензът е изтрит.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'Възникна проблем при изписването на лиценза. Моля, опитайте отново.',
        'success' => 'Лицензът е изписан',
        'not_enough_seats' => 'Няма достатъчно лицензи за изписване',
        'mismatch' => 'Броя лицензни места не отговаря на броя лицензи',
        'unavailable' => 'Този лиценз за работно място не е наличен за изписване.',
        'license_is_inactive' => 'Лиценза е изтекъл или прекратен.',
    ],

    'checkin' => [
        'error' => 'Възникна проблем при вписването на лиценза. Моля, опитайте отново.',
        'not_reassignable' => 'Лиценза е изпозлван',
        'success' => 'Лицензът е вписан',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];
