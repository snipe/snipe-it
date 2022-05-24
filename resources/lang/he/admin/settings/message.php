<?php

return [

    'update' => [
        'error'                 => 'אירעה שגיאה בעת העדכון.',
        'success'               => 'ההגדרות עודכנו בהצלחה.',
    ],
    'backup' => [
        'delete_confirm'        => 'האם אתה בטוח שברצונך למחוק קובץ גיבוי זה? לא ניתן לבטל פעולה זו.',
        'file_deleted'          => 'קובץ הגיבוי נמחק בהצלחה.',
        'generated'             => 'קובץ גיבוי חדש נוצר בהצלחה.',
        'file_not_found'        => 'קובץ גיבוי זה לא נמצא בשרת.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'האם ברצונך לשחזר את המסד נתונים מ: קובץ?'
    ],
    'purge' => [
        'error'     => 'אירעה שגיאה בעת הטיהור.',
        'validation_failed'     => 'אישור הטיהור שלך שגוי. הקלד את המילה "DELETE" בתיבת האישור.',
        'success'               => 'רשומות נמחקו בהצלחה.',
    ],
    'mail' => [
        'sending' => 'שולח מייל לבדיקה...',
        'success' => 'המייל נשלח!',
        'error' => 'מייל לא נשלח.',
        'additional' => 'קיימות שגיאות נוספות. בדוק במייל שלך ובלוגים.'
    ],
    'ldap' => [
        'testing' => 'בודק חיבור LDAP, שאילתות ומבנה נתונים...',
        '500' => 'שגיאה 500, בבקשה בודק את הלוגים בשרת לעוד נתונים.',
        'error' => 'משהו השתבש אופסי פופסי :(',
        'sync_success' => 'בדיקה מול שרת LDAP ל 10 משתמשים בוצעה בהתאם להגדרות שלך:',
        'testing_authentication' => 'בודק אימות מול שרת LDAP...',
        'authentication_success' => 'התחברות לשרת LDAפ עברה בהצלחה!'
    ],
    'slack' => [
        'sending' => 'שולח הודעת Slack לבדיקה...',
        'success_pt1' => 'הבדיקה עברה בהצלחה! בדוק את ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 שגיאת שרת.',
        'error' => 'משהו השתבש אופסי פופסי.',
    ]
];
