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
        'restore_warning'       => 'بله، آن را بازیابی کنید. من تصدیق می‌کنم که با این کار تمام داده‌های موجود در پایگاه داده بازنویسی می‌شود. با این کار همه کاربران فعلی شما (از جمله شما) نیز از سیستم خارج می شوند.
',
        'restore_confirm'       => 'آیا مطمئن هستید که می خواهید پایگاه داده خود را از :filename بازیابی کنید؟
'
    ],
    'purge' => [
        'error'     => 'در حین پاکسازی خطایی رخ داد. ',
        'validation_failed'     => 'تایید پاکسازی ناصحیح است. لطفا کلمه ی "حذف" را در جعبه ی تاییدیه تایپ کنید.',
        'success'               => 'سوابق حذف شده با موفقیت پاکسازی شده اند.',
    ],
    'mail' => [
        'sending' => 'ارسال ایمیل تست',
        'success' => 'ایمیل فرستاده شد!
',
        'error' => 'خطا در ارسال ایمیل',
        'additional' => 'پیغام خطای اضافی ارائه نشده است. تنظیمات ایمیل و گزارش برنامه خود را بررسی کنید.
'
    ],
    'ldap' => [
        'testing' => 'تست اتصال LDAP، Binding و Query ...
',
        '500' => '500 خطای سرور. لطفا برای اطلاعات بیشتر گزارش های سرور خود را بررسی کنید.
',
        'error' => 'اوه! مشکلی پیش آمده',
        'sync_success' => 'نمونه ای از 10 کاربر بر اساس تنظیمات شما از سرور LDAP برگردانده شده است:
',
        'testing_authentication' => 'تست احراز هویت LDAP...
',
        'authentication_success' => 'کاربر در برابر LDAP با موفقیت احراز هویت شد!
'
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
