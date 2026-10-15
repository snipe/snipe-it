<?php

return [

    'does_not_exist' => 'License does not exist or you do not have permission to view it.',
    'user_does_not_exist' => 'User does not exist or you do not have permission to view them.',
    'asset_does_not_exist' => 'دارایی شما در حال تلاش برای ارتباط با این مجوز وجود ندارد.',
    'owner_doesnt_match_asset' => 'دارایی شما در حال تلاش برای ارتباط با این مجوز توسط کسی غیر از فرد در اختصاص داده شده به انتخاب کرکره متعلق به.
',
    'assoc_users' => 'این مجوز در حال حاضر به یک کاربر چک کردن و پاک نمی شود. لطفا مجوز در اولین بار چک کنید، و سپس سعی کنید دوباره حذف کنید.',
    'select_asset_or_person' => 'شما باید دارایی یا یک کاربر را انتخاب کنید، اما نه هر دو.',
    'not_found' => 'فایل یافت نشد',
    'seats_available' => ':seat_count seats available',

    'create' => [
        'error' => 'مجوز ایجاد نمی شد، لطفا دوباره امتحان کنید.',
        'success' => 'مجوز ایجاد نمی شد، لطفا دوباره امتحان کنید.مجوز ایجاد نمی شد، لطفا دوباممجوز موفقیت ایجاد شده است.اد شده است.ره امتحان کنید.',
    ],

    'deletefile' => [
        'error' => 'فایل حذف نمی شود. لطفا دوباره تلاش کنید.',
        'success' => 'فایل با موفقیت حذف شده است.',
    ],

    'upload' => [
        'error' => 'فایل) آپلود نیست. لطفا دوباره تلاش کنید.',
        'success' => 'فایل (موفقیت آپلود شد.',
        'nofiles' => 'شما هر فایل برای آپلود انتخاب کنید، و یا فایل شما در حال تلاش برای آپلود بیش از حد بزرگ است',
        'invalidfiles' => 'یک یا چند فایل شما بیش از حد بزرگ است و یا یک نوع فایل است که مجاز نیست. انواع فایلهای مجاز PNG، GIF، JPG، JPEG، DOC، DOCX، PDF، TXT، ZIP، RAR، RTF، XML و LIC است.',
    ],

    'update' => [
        'error' => 'مجوز به روز رسانی نمی شد، لطفا دوباره امتحان کنید',
        'success' => 'مجوز موفقیت به روز شد.',
    ],

    'delete' => [
        'confirm' => 'آیا شما مطمئن هستید که میخواهید حذف این مجوز؟',
        'error' => 'بود یک موضوع حذف مجوز وجود دارد. لطفا دوباره تلاش کنید.',
        'success' => 'مجوز موفقیت حذف شد.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'بود یک موضوع چک کردن مجوز وجود دارد. لطفا دوباره تلاش کنید.',
        'success' => 'مجوز خارج بررسی شد موفقیت',
        'not_enough_seats' => 'Not enough license seats available for checkout',
        'mismatch' => 'The license seat provided does not match the license',
        'unavailable' => 'This seat is not available for checkout.',
        'license_is_inactive' => 'This license is expired or terminated.',
    ],

    'checkin' => [
        'error' => 'بود یک موضوع چک کردن در مجوز وجود دارد. لطفا دوباره تلاش کنید.',
        'not_reassignable' => 'Seat has been used',
        'success' => 'مجوز بررسی شده با موفقیت',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];
