<?php

return array(
    'about_licenses_title'      => 'Lisanslar Hakkında',
    'about_licenses'            => 'Lisanslar yazılım takibi için kullanılır.  Kullanıcı sayısı kadar kişide kullanılabilir',
    'checkin'  					=> 'Lisans Kullanıcısı Girişi',
    'checkout_history'  		=> 'Çıkış Geçmişi',
    'checkout'  				=> 'Lisans Kullanıcı Çıkışı',
    'edit'  					=> 'Lisansı Düzenle',
    'filetype_info'				=> 'İzin verilen dosya türleri; png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar.',
    'clone'  					=> 'Lisansı Kopyala',
    'history_for'  				=> 'Geçmiş ',
    'in_out'  					=> 'Giriş/Çıkış',
    'info'  					=> 'Lisans Bilgisi',
    'license_seats'  			=> 'Lisans Kullanıcıları',
    'seat'  					=> 'Kullanıcı',
    'seats'  					=> 'Kullanıcılar',
    'software_licenses'  		=> 'Yazılım Lisansları',
    'user'  					=> 'Kullanıcı',
    'view'  					=> 'Lisansı Göster',
    'delete_disabled'           => 'Bazı koltuklar hala kullanıma alınmış olduğundan bu lisans henüz silinemez.',
    'bulk'                      =>
        [
            'checkin_all'           => [
                'button'            => 'Tüm koltukları ayır',
                'modal'             => 'This will action checkin one seat. | This action will checkin all :checkedout_seats_count seats for this license.',
                'enabled_tooltip'   => 'Checkin ALL seats for this license from both users and assets',
                'disabled_tooltip'  => 'This is disabled because there are no seats currently checked out',
                'success'           => 'License successfully checked in! | All licenses were successfully checked in!',
                'log_msg'           => 'Checked in via bulk license checkout in license GUI',
            ],

            'checkout_all'              => [
                'button'                => 'Tüm koltukları incele',
                'modal'                 => 'This action will checkout one seat to the first available user. | This action will checkout all :available_seats_count seats to the first available users. A user is considered available for this seat if they do not already have this license checked out to them, and the Auto-Assign License property is enabled on their user account.',
                'enabled_tooltip'   => 'Checkout ALL seats (or as many as are available) to ALL users',
                'disabled_tooltip'  => 'Ulaşılabilir koltruk olmadığı için bu devre dışı bırakıldı',
                'success'           => 'License successfully checked out! | :count licenses were successfully checked out!',
                'error_no_seats'    => 'There are no remaining seats left for this license.',
                'warn_not_enough_seats'    => ':count users were assigned this license, but we ran out of available license seats.',
                'warn_no_avail_users'    => 'Nothing to do. There are no users who do not already have this license assigned to them.',
                'log_msg'           => 'Checked out via bulk license checkout in license GUI',


            ],
    ],
);
