<?php

return [
    'not_found' => 'لم يتم العثور على سند صيانة الأصل المطلوب!',
    'delete' => [
        'confirm' => 'هل أنت متأكد من رغبتك في حذف سند صيانة الأصل؟',
        'error' => 'حدثت مشكلة في عملية الحذف لسند صيانة الأصل. الرجاء المحاولة مرة اُخرى.',
        'success' => 'تم حذف سند صيانة الأصل بنجاح.',
    ],
    'create' => [
        'error' => 'لم يتم إنشاء سند صيانة الأصل، الرجاء المحاولة مرة أخرى.',
        'success' => 'تم إنشاء سند صيانة الأصل بنجاح.',
    ],
    'edit' => [
        'error' => 'لم يتم تعديل سند صيانة الأصل، يرجى إعادة المحاولة.',
        'success' => 'تم تعديل سند صيانة الأصل بنجاح.',
    ],
    'asset_maintenance_incomplete' => 'لم يكتمل بعد',
    'warranty' => 'الضمان',
    'not_warranty' => 'لا يوجد ضمان',
    'complete' => [
        'confirm' => 'Are you sure you want to mark this maintenance as complete? This cannot be undone.',
        'success' => 'Maintenance marked as complete.',
        'error' => 'There was an issue marking this maintenance as complete. Please try again.',
    ],
    'bulk_delete' => 'No maintenance records were deleted (:skipped skipped).|Deleted :count maintenance record. (:skipped skipped)|Deleted :count maintenance records. (:skipped skipped)',
    'bulk_complete' => 'No maintenance records were marked complete (:skipped skipped or already complete).|Marked :count maintenance record complete. (:skipped skipped or already complete)|Marked :count maintenance records complete. (:skipped skipped or already complete)',
];
