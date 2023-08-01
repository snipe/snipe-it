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
        'restore_warning'       => 'Evet, geri yükleyin. Bunun, şu anda veritabanında bulunan mevcut verilerin üzerine yazılacağını kabul ediyorum. Bu aynı zamanda (siz dahil) tüm mevcut kullanıcılarınızın oturumunu kapatacaktır.',
        'restore_confirm'       => 'Veritabanınızı :filename\'den geri yüklemek istediğinizden emin misiniz?'
    ],
    'purge' => [
        'error'     => 'Temizleme sırasında bir hata oluştu. ',
        'validation_failed'     => 'Temizle onay kodu yanlıştır. Lütfen onay kutusuna "DELETE" yazın.',
        'success'               => 'Silinen kayıtları başarıyla temizlendi.',
    ],
    'mail' => [
        'sending' => 'Test maili gönderiliyor...',
        'success' => 'Mail gönder!',
        'error' => 'Mail gönderilemedi.',
        'additional' => 'Ek hata mesajı sağlanmadı. Posta ayarlarınızı ve uygulama günlüğünüzü kontrol edin.'
    ],
    'ldap' => [
        'testing' => 'LDAP bağlantısı deneniyor, bağlanılıyor ve sorgulanıyor ...',
        '500' => '500 Sunucu Hatası. Daha fazla bilgi için lütfen sunucu günlüklerinizi kontrol edin.',
        'error' => 'Bir şeyler yanlış gitti :(',
        'sync_success' => 'Ayarlarınıza göre LDAP sunucusundan döndürülen 10 kullanıcıdan oluşan bir örnek:',
        'testing_authentication' => 'LDAP kimlik doğrulaması deneniyor...',
        'authentication_success' => 'LDAP kullanıcı kimliği başarıyla doğrulandı!'
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
