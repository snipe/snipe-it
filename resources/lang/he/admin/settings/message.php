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
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'אירעה שגיאה בעת הטיהור.',
        'validation_failed'     => 'אישור הטיהור שלך שגוי. הקלד את המילה "DELETE" בתיבת האישור.',
        'success'               => 'רשומות נמחקו בהצלחה.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'מייל לא נשלח.',
        'additional' => 'קיימות שגיאות נוספות. בדוק במייל שלך ובלוגים.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
    ]
];
