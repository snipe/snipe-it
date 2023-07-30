<?php

return [

    'undeployable' 		=> '<strong> אזהרה: </strong> הנכס הזה סומן כבלתי ניתן לפריסה כעת. אם סטטוס זה השתנה, עדכן את סטטוס הנכס.',
    'does_not_exist' 	=> 'הנכס אינו קיים.',
    'does_not_exist_or_not_requestable' => 'הנכס אינו קיים או לא זמין.',
    'assoc_users'	 	=> 'הנכס הזה מסומן כרגע למשתמש ולא ניתן למחוק אותו. בדוק תחילה את הנכס ולאחר מכן נסה למחוק שוב.',

    'create' => [
        'error'   		=> 'הנכס לא נוצר, נסה שוב. You',
        'success' 		=> 'הנכס נוצר בהצלחה. :)',
    ],

    'update' => [
        'error'   			=> 'הנכס לא עודכן, נסה שוב',
        'success' 			=> 'הנכס עודכן בהצלחה.',
        'nothing_updated'	=>  'לא נבחרו שדות, ולכן דבר לא עודכן.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'הנכס לא שוחזר, נסה שוב',
        'success' 		=> 'הנכס שוחזר בהצלחה.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'ביקורת הנכסים נכשלה. בבקשה נסה שוב.',
        'success' 		=> 'ביקורת נכסים נרשמה בהצלחה.',
    ],


    'deletefile' => [
        'error'   => 'הקובץ לא נמחק. בבקשה נסה שוב.',
        'success' => 'הקובץ נמחק בהצלחה.',
    ],

    'upload' => [
        'error'   => 'הקובץ לא הועלה. בבקשה נסה שוב.',
        'success' => 'הקבצים הועלו בהצלחה.',
        'nofiles' => 'לא בחרת קבצים להעלאה, או שהקובץ שאתה מנסה להעלות גדול מדי',
        'invalidfiles' => 'אחד או יותר מהקבצים שלך גדול מדי או שהוא סוג קובץ שאינו מותר. סוגי קבצים מותרים הם png, gif, jpg, doc, docx, pdf ו- txt.',
    ],

    'import' => [
        'error'                 => 'פריטים מסוימים לא ייבאו כראוי.',
        'errorDetail'           => 'הפריטים הבאים לא יובאו בגלל שגיאות.',
        'success'               => 'הקובץ שלך יובא',
        'file_delete_success'   => 'הקובץ שלך נמחק בהצלחה',
        'file_delete_error'      => 'לא ניתן היה למחוק את הקובץ',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'האם אתה בטוח שברצונך למחוק את הנכס הזה?',
        'error'   		=> 'היתה בעיה במחיקת הנכס. בבקשה נסה שוב.',
        'nothing_updated'   => 'לא נבחרו נכסים ולכן לא נמחק דבר.',
        'success' 		=> 'הנכס נמחק בהצלחה.',
    ],

    'checkout' => [
        'error'   		=> 'הנכס לא נבדק, נסה שוב',
        'success' 		=> 'הנכס הוצא בהצלחה.',
        'user_does_not_exist' => 'משתמש זה אינו חוקי. בבקשה נסה שוב.',
        'not_available' => 'הנכס הזה אינו זמין לקופה!',
        'no_assets_selected' => 'עליך לבחור לפחות בנכס אחד מהרשימה',
    ],

    'checkin' => [
        'error'   		=> 'הנכס לא נבדק, נסה שוב',
        'success' 		=> 'הנכס נבדק בהצלחה.',
        'user_does_not_exist' => 'משתמש זה אינו חוקי. בבקשה נסה שוב.',
        'already_checked_in'  => 'הנכס כבר נבדק.',

    ],

    'requests' => [
        'error'   		=> 'הנכס לא התבקש, נסה שוב',
        'success' 		=> 'הנכס המבוקש בהצלחה.',
        'canceled'      => 'בקשת התשלום בוטלה בהצלחה',
    ],

];
