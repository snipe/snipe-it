<?php

return [

    'update' => [
        'error'                 => 'Güncelleme yapılırken bir hata oluştu. ',
        'success'               => 'Ayarlar güncellendi.',
    ],
    'backup' => [
        'delete_confirm'        => 'Bu yedek dosyayı silmek istediğinizden emin misiniz? Bu eylem geri alınamaz. ',
        'file_deleted'          => 'Yedek dosyası başarıyla silindi.',
        'generated'             => 'Yeni bir yedekleme dosyası başarıyla oluşturuldu.',
        'file_not_found'        => 'Bu yedek dosyası sunucuda bulunamadı.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Temizleme sırasında bir hata oluştu. ',
        'validation_failed'     => 'Temizle onay kodu yanlıştır. Lütfen onay kutusuna "DELETE" yazın.',
        'success'               => 'Silinen kayıtları başarıyla temizlendi.',
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
