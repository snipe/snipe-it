<?php

return [

    'does_not_exist' => 'الترخيص غير موجود أو ليس لديك الصلاحية لعرضه.',
    'user_does_not_exist' => 'المستخدم غير موجود أو ليس لديك الصلاحية لعرضها.',
    'asset_does_not_exist' => 'الأصل اللذي تحاول ربطه مع هذا الترخيص غير موجود.',
    'owner_doesnt_match_asset' => 'الأصل اللذي تحاول ربطه مع هذا الترخيص حاليا مملوك لشخص اخر غير اللذي تم اختياره من القائمة المنسدلة.',
    'assoc_users' => 'هذا الترخيص حاليا مخرج لمستخدم ولا يمكن حذفه. يرجى التحقق من الترخيص في البداية، ثم محاولة الحذف مرة أخرى. ',
    'select_asset_or_person' => 'يجب تحديد أصل أو مستخدم، وليس كليهما.',
    'not_found' => 'لم يتم العثور على الترخيص',
    'seats_available' => ':seat_count المقاعد المتاحة',

    'create' => [
        'error' => 'لم يتم إنشاء الترخيص، يرجى إعادة المحاولة.',
        'success' => 'تم إنشاء الترخيص بنجاح.',
    ],

    'deletefile' => [
        'error' => 'لم يتم حذف الملف. الرجاء المحاولة مرة اخرى.',
        'success' => 'تم حذف الملف بنجاح.',
    ],

    'upload' => [
        'error' => 'لم يتم تحميل الملف(ات). حاول مرة اخرى.',
        'success' => 'تم تحميل الملف(ات) بنجاح.',
        'nofiles' => 'لم تحدد أي ملفات للتحميل، أو أن الملف الذي تحاول تحميله كبير جدا',
        'invalidfiles' => 'واحد أو أكثر من الملفات كبير جدا أو انه نوع ملف غير مسموح به. أنواع الملفات المسموح بها هي png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml, و lic.',
    ],

    'update' => [
        'error' => 'لم يتم تحديث الترخيص، يرجى إعادة المحاولة',
        'success' => 'تم تحديث الترخيص بنجاح.',
    ],

    'delete' => [
        'confirm' => 'هل أنت متأكد من رغبتك في حذف هذا الترخيص؟',
        'error' => 'حدثت مشكلة أثناء حذف الترخيص. يرجى إعادة المحاولة.',
        'success' => 'تم حذف الترخيص بنجاح.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'حدثت مشكلة أثناء اخراج الترخيص. يرجى إعادة المحاولة.',
        'success' => 'تم اخراج الترخيص بنجاح',
        'not_enough_seats' => 'لا توجد مقاعد ترخيص كافية متاحة للدفع',
        'mismatch' => 'The license seat provided does not match the license',
        'unavailable' => 'This seat is not available for checkout.',
        'license_is_inactive' => 'This license is expired or terminated.',
    ],

    'checkin' => [
        'error' => 'حدثت مشكلة في التحقق من الترخيص. يرجى إعادة المحاولة.',
        'not_reassignable' => 'Seat has been used',
        'success' => 'تم ادخال الترخيص بنجاح',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];
