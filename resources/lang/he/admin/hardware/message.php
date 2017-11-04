<?php

return array(

    'undeployable' 		=> '<strong> אזהרה: </strong> הנכס הזה סומן כבלתי ניתן לפריסה כעת. אם סטטוס זה השתנה, עדכן את סטטוס הנכס.',
    'does_not_exist' 	=> 'הנכס אינו קיים.',
    'does_not_exist_or_not_requestable' => 'ניסיון יפה. נכס זה אינו קיים או שאינו ניתן לביצוע.',
    'assoc_users'	 	=> 'הנכס הזה מסומן כרגע למשתמש ולא ניתן למחוק אותו. בדוק תחילה את הנכס ולאחר מכן נסה למחוק שוב.',

    'create' => array(
        'error'   		=> 'הנכס לא נוצר, נסה שוב. You',
        'success' 		=> 'הנכס נוצר בהצלחה. :)'
    ),

    'update' => array(
        'error'   			=> 'הנכס לא עודכן, נסה שוב',
        'success' 			=> 'הנכס עודכן בהצלחה.',
        'nothing_updated'	=>  'לא נבחרו שדות, ולכן דבר לא עודכן.',
    ),

    'restore' => array(
        'error'   		=> 'הנכס לא שוחזר, נסה שוב',
        'success' 		=> 'הנכס שוחזר בהצלחה.'
    ),

    'audit' => array(
        'error'   		=> 'ביקורת הנכסים נכשלה. בבקשה נסה שוב.',
        'success' 		=> 'ביקורת נכסים נרשמה בהצלחה.'
    ),


    'deletefile' => array(
        'error'   => 'הקובץ לא נמחק. בבקשה נסה שוב.',
        'success' => 'הקובץ נמחק בהצלחה.',
    ),

    'upload' => array(
        'error'   => 'הקובץ לא הועלה. בבקשה נסה שוב.',
        'success' => 'הקבצים הועלו בהצלחה.',
        'nofiles' => 'לא בחרת קבצים להעלאה, או שהקובץ שאתה מנסה להעלות גדול מדי',
        'invalidfiles' => 'אחד או יותר מהקבצים שלך גדול מדי או שהוא סוג קובץ שאינו מותר. סוגי קבצים מותרים הם png, gif, jpg, doc, docx, pdf ו- txt.',
    ),

    'import' => array(
        'error'                 => 'פריטים מסוימים לא ייבאו כראוי.',
        'errorDetail'           => 'הפריטים הבאים לא יובאו בגלל שגיאות.',
        'success'               => "הקובץ שלך יובא",
        'file_delete_success'   => "הקובץ שלך נמחק בהצלחה",
        'file_delete_error'      => "לא ניתן היה למחוק את הקובץ",
    ),


    'delete' => array(
        'confirm'   	=> 'האם אתה בטוח שברצונך למחוק את הנכס הזה?',
        'error'   		=> 'היתה בעיה במחיקת הנכס. בבקשה נסה שוב.',
        'nothing_updated'   => 'לא נבחרו נכסים ולכן לא נמחק דבר.',
        'success' 		=> 'הנכס נמחק בהצלחה.'
    ),

    'checkout' => array(
        'error'   		=> 'הנכס לא נבדק, נסה שוב',
        'success' 		=> 'הנכס הוצא בהצלחה.',
        'user_does_not_exist' => 'משתמש זה אינו חוקי. בבקשה נסה שוב.',
        'not_available' => 'הנכס הזה אינו זמין לקופה!',
        'no_assets_selected' => 'You must select at least one asset from the list'
    ),

    'checkin' => array(
        'error'   		=> 'הנכס לא נבדק, נסה שוב',
        'success' 		=> 'הנכס נבדק בהצלחה.',
        'user_does_not_exist' => 'משתמש זה אינו חוקי. בבקשה נסה שוב.',
        'already_checked_in'  => 'הנכס כבר נבדק.',

    ),

    'requests' => array(
        'error'   		=> 'הנכס לא התבקש, נסה שוב',
        'success' 		=> 'הנכס המבוקש בהצלחה.',
        'canceled'      => 'בקשת התשלום בוטלה בהצלחה'
    )

);
