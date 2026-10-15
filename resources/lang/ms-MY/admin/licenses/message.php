<?php

return [

    'does_not_exist' => 'License does not exist or you do not have permission to view it.',
    'user_does_not_exist' => 'User does not exist or you do not have permission to view them.',
    'asset_does_not_exist' => 'Harta yang anda ingin sekutukan dengan lesen tidak wujud.',
    'owner_doesnt_match_asset' => 'Harta yang anda ingin sekutukan dengan lesen ini dimiliki oleh orang lain selain dari orang yang dipilih dalam pilihan yang disekutukan.',
    'assoc_users' => 'Lesen ini telah diagihkan kepada pengguna dan tidak boleh dihapuskan. Sila semak lesen terlebih dahulu, dan cuba hapus semula.  ',
    'select_asset_or_person' => 'Anda mesti memilih aset atau pengguna, tetapi tidak kedua-duanya.',
    'not_found' => 'Lesen tidak ditemui',
    'seats_available' => ':seat_count seats available',

    'create' => [
        'error' => 'Lesen gagal dicipta, sila cuba lagi.',
        'success' => 'Lesen berjaya dicipta.',
    ],

    'deletefile' => [
        'error' => 'Fail tidak dipadam. Sila cuba lagi.',
        'success' => 'Fail berjaya dipadam.',
    ],

    'upload' => [
        'error' => 'Fail tidak dimuat naik. Sila cuba lagi.',
        'success' => 'Fail berjaya dimuat naik.',
        'nofiles' => 'Anda tidak memilih sebarang fail untuk dimuat naik, atau fail yang anda cuba muat naik terlalu besar',
        'invalidfiles' => 'Satu atau lebih daripada fail anda terlalu besar atau merupakan filetype yang tidak dibenarkan. Filetype yang dibenarkan adalah png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml, dan lic.',
    ],

    'update' => [
        'error' => 'Lesen gagal dikemaskini, sila cuba lagi',
        'success' => 'Lesen berjaya dikemaskini.',
    ],

    'delete' => [
        'confirm' => 'Anda pasti and ingin menghapuskan lesen ini?',
        'error' => 'Ada isu semada menghapuskan lesen, sila cuba lagi.',
        'success' => 'Lesen berjaya dihapuskan.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'Ada isu semasa agihan lesen. Sila cuba lagi.',
        'success' => 'Lesen berjaya diagihkan',
        'not_enough_seats' => 'Not enough license seats available for checkout',
        'mismatch' => 'The license seat provided does not match the license',
        'unavailable' => 'This seat is not available for checkout.',
        'license_is_inactive' => 'This license is expired or terminated.',
    ],

    'checkin' => [
        'error' => 'Ada isu semasa terima lesen. Sila cuba lagi.',
        'not_reassignable' => 'Seat has been used',
        'success' => 'Lesen berjaya diterima',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];
