<?php

return array(

    'accepted'                  => 'קיבלת בהצלחה את הנכס הזה.',
    'declined'                  => 'דחיית את הנכס הזה בהצלחה.',
    'bulk_manager_warn'	        => 'המשתמשים שלך עודכנו בהצלחה, אך רשומת המנהל שלך לא נשמרה מפני שהמנהל שבחרת נבחר גם ברשימת המשתמשים כדי לערוך, והמשתמשים לא יכולים להיות המנהל שלהם. בחר שוב את המשתמשים שלך, למעט המנהל.',
    'user_exists'               => 'משתמש כבר קיים!',
    'user_not_found'            => 'משתמש [: id] אינו קיים.',
    'user_login_required'       => 'יש להזין את שדה הכניסה',
    'user_password_required'    => 'נדרשת הסיסמה.',
    'insufficient_permissions'  => 'הרשאות לא מספיקות.',
    'user_deleted_warning'      => 'משתמש זה נמחק. יהיה עליך לשחזר משתמש זה כדי לערוך אותם או להקצות להם נכסים חדשים.',
    'ldap_not_configured'        => 'שילוב LDAP לא הוגדר עבור התקנה זו.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',


    'success' => array(
        'create'    => 'המשתמש נוצר בהצלחה.',
        'update'    => 'המשתמש עודכן בהצלחה.',
        'update_bulk'    => 'המשתמשים עודכנו בהצלחה!',
        'delete'    => 'המשתמש נמחק בהצלחה.',
        'ban'       => 'המשתמש אוסר בהצלחה.',
        'unban'     => 'המשתמש בוטל בהצלחה.',
        'suspend'   => 'המשתמש הושעה בהצלחה.',
        'unsuspend' => 'המשתמש בוטל בהצלחה.',
        'restored'  => 'המשתמש שוחזר בהצלחה.',
        'import'    => 'המשתמשים יובאו בהצלחה.',
    ),

    'error' => array(
        'create' => 'היתה בעיה ביצירת המשתמש. בבקשה נסה שוב.',
        'update' => 'היתה בעיה בעדכון המשתמש. בבקשה נסה שוב.',
        'delete' => 'היתה בעיה במחיקת המשתמש. בבקשה נסה שוב.',
        'delete_has_assets' => 'למשתמש זה יש פריטים שהוקצו ולא ניתן למחוק אותם.',
        'unsuspend' => 'היתה בעיה בהתעלמות מהמשתמש. בבקשה נסה שוב.',
        'import'    => 'היתה בעיה בייבוא ​​משתמשים. בבקשה נסה שוב.',
        'asset_already_accepted' => 'הנכס כבר התקבל.',
        'accept_or_decline' => 'עליך לקבל או לדחות את הנכס.',
        'incorrect_user_accepted' => 'הנכס שניסית לקבל לא נבדק לך.',
        'ldap_could_not_connect' => 'לא ניתן להתחבר לשרת LDAP. בדוק את תצורת שרת LDAP בקובץ תצורת LDAP. <br> שגיאה משרת LDAP:',
        'ldap_could_not_bind' => 'לא ניתן היה להתחבר לשרת LDAP. בדוק את תצורת שרת LDAP בקובץ תצורת LDAP. <br> שגיאה משרת LDAP:',
        'ldap_could_not_search' => 'לא ניתן לחפש בשרת LDAP. בדוק את תצורת שרת LDAP בקובץ תצורת LDAP. <br> שגיאה משרת LDAP:',
        'ldap_could_not_get_entries' => 'לא ניתן לקבל רשומות משרת LDAP. בדוק את תצורת שרת LDAP בקובץ תצורת LDAP. <br> שגיאה משרת LDAP:',
        'password_ldap' => 'הסיסמה עבור חשבון זה מנוהלת על ידי LDAP / Active Directory. צור קשר עם מחלקת ה- IT כדי לשנות את הסיסמה שלך.',
    ),

    'deletefile' => array(
        'error'   => 'הקובץ לא נמחק. בבקשה נסה שוב.',
        'success' => 'הקובץ נמחק בהצלחה.',
    ),

    'upload' => array(
        'error'   => 'הקובץ לא הועלה. בבקשה נסה שוב.',
        'success' => 'הקבצים הועלו בהצלחה.',
        'nofiles' => 'לא בחרת קבצים להעלאה',
        'invalidfiles' => 'אחד או יותר מהקבצים שלך גדול מדי או שהוא סוג קובץ שאינו מותר. סוגי קבצים מותרים הם png, gif, jpg, doc, docx, pdf ו- txt.',
    ),

);