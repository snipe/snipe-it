<?php

return [

    'does_not_exist' => 'المورد غير مجود.',

    'create' => [
        'error'   => 'لم يتم إنشاء المورد، الرجاء المحاولة مرة أخرى.',
        'success' => 'تم إنشاء المورد بنجاح.',
    ],

    'update' => [
        'error'   => 'لم يتم تحديث المورد، يرجى إعادة المحاولة',
        'success' => 'تم تحديث المورد بنجاح.',
    ],

    'delete' => [
        'confirm'   => 'هل أنت متأكد من رغبتك في حذف هذا المورد؟',
        'error'   => 'حدثت مشكلة أثناء حذف المورد. حاول مرة اخرى.',
        'success' => 'تم حذف المورد بنجاح.',
        'assoc_assets'     => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'     => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'     => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    ],

];
