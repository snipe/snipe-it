<?php

return [

    'does_not_exist' => 'License does not exist or you do not have permission to view it.',
    'user_does_not_exist' => 'User does not exist or you do not have permission to view them.',
    'asset_does_not_exist' => 'הנכס שאתה מנסה לשייך לרישיון זה אינו קיים.',
    'owner_doesnt_match_asset' => 'הנכס שאתה מנסה לשייך לרישיון זה נמצא בבעלות somene אחר מאשר האדם שנבחר שהוקצה לתפריט הנפתח.',
    'assoc_users' => 'רישיון זה נבדק כעת למשתמש ולא ניתן למחוק אותו. בדוק תחילה את הרישיון ולאחר מכן נסה למחוק שוב.',
    'select_asset_or_person' => 'עליך לבחור נכס או משתמש, אך לא את שניהם.',
    'not_found' => 'License not found',
    'seats_available' => ':seat_count seats available',

    'create' => [
        'error' => 'הרישיון לא נוצר, נסה שוב.',
        'success' => 'הרישיון נוצר בהצלחה.',
    ],

    'deletefile' => [
        'error' => 'הקובץ לא נמחק. בבקשה נסה שוב.',
        'success' => 'הקובץ נמחק בהצלחה.',
    ],

    'upload' => [
        'error' => 'הקובץ לא הועלה. בבקשה נסה שוב.',
        'success' => 'הקבצים הועלו בהצלחה.',
        'nofiles' => 'לא בחרת קבצים להעלאה, או שהקובץ שאתה מנסה להעלות גדול מדי',
        'invalidfiles' => 'אחד או יותר מהקבצים שלך גדול מדי או שהוא סוג קובץ שאינו מותר. סוגי קבצים מותרים הם png, gif, jpg, jpeg, docx, pdf, txt, zip, rar, rtf, XML ו- lic.',
    ],

    'update' => [
        'error' => 'הרישיון לא עודכן, נסה שוב',
        'success' => 'הרישיון עודכן בהצלחה.',
    ],

    'delete' => [
        'confirm' => 'האם אתה בטוח שברצונך למחוק רישיון זה?',
        'error' => 'היתה בעיה במחיקת הרישיון. בבקשה נסה שוב.',
        'success' => 'הרישיון נמחק בהצלחה.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'היתה בעיה לבדוק את הרישיון. בבקשה נסה שוב.',
        'success' => 'הרשיון נבדק בהצלחה',
        'not_enough_seats' => 'Not enough license seats available for checkout',
        'mismatch' => 'The license seat provided does not match the license',
        'unavailable' => 'This seat is not available for checkout.',
        'license_is_inactive' => 'This license is expired or terminated.',
    ],

    'checkin' => [
        'error' => 'היתה בעיה בבדיקת הרישיון. בבקשה נסה שוב.',
        'not_reassignable' => 'Seat has been used',
        'success' => 'הרישיון נבדק בהצלחה',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];
