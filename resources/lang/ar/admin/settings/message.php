<?php

return [

    'update' => [
        'error'                 => 'حدث خطأ أثناء التحديث. ',
        'success'               => 'تم تحديث الإعدادات بنجاح.',
    ],
    'backup' => [
        'delete_confirm'        => 'هل تريد بالتأكيد حذف ملف النسخة الاحتياطية هذا؟ لا يمكن التراجع عن هذا الإجراء.',
        'file_deleted'          => 'تم حذف ملف النسخ الاحتياطي بنجاح.',
        'generated'             => 'تم إنشاء ملف نسخ احتياطي جديد بنجاح.',
        'file_not_found'        => 'تعذر العثور على ملف النسخ الاحتياطي هذا على الملقم.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'حدث خطأ أثناء التطهير.',
        'validation_failed'     => 'تأكيد التطهير غير صحيح. الرجاء كتابة الكلمة "ديليت" في مربع التأكيد.',
        'success'               => 'تمت إزالة السجلات المحذوفة بنجاح.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'webhook' => [
        'sending' => 'Sending :app test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. :app responded with: :error_message',
        'error_misc' => 'Something went wrong. :( ',
    ]
];
