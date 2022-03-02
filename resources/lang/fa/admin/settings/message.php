<?php

return [

    'update' => [
        'error'                 => 'در حین به روزرسانی خطایی رخ داد. ',
        'success'               => 'تنظیمات با موفقیت به روزرسانی شد.',
    ],
    'backup' => [
        'delete_confirm'        => 'آیا شما مطمئن هستید که می خواهید این فایل پشتیبانی را حذف کنید؟ این کار برگشت ناپذیر است. ',
        'file_deleted'          => 'فایل پشتیبانی با موفقیت حذف شد. ',
        'generated'             => 'یک فایل پشتیبانی جدید با موفقیت ساخته شد.',
        'file_not_found'        => 'فایل پشتیبانی بر روی سرور یافت نمی شود.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'در حین پاکسازی خطایی رخ داد. ',
        'validation_failed'     => 'تایید پاکسازی ناصحیح است. لطفا کلمه ی "حذف" را در جعبه ی تاییدیه تایپ کنید.',
        'success'               => 'سوابق حذف شده با موفقیت پاکسازی شده اند.',
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
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
    ]
];
