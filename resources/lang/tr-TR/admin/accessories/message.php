<?php

return array(

    'does_not_exist' => '[:id] numaralı aksesuar bulunmuyor.',
    'not_found' => 'O aksesuar bulunamadı.',
    'assoc_users'	 => 'Bu aksesuardan :count adet kullanıcılara çıkış yapıldı. Lütfen aksesuar girişi yapınız ve tekrar deneyin.',

    'create' => array(
        'error'   => 'Aksesuar oluşturma başarısız. lütfen tekrar deneyin.',
        'success' => 'Aksesuar başarıyla güncellendi.'
    ),

    'update' => array(
        'error'   => 'Aksesuar güncellenmedi. Lütfen tekrar deneyin',
        'success' => 'Aksesuar başarı ile güncellendi.'
    ),

    'delete' => array(
        'confirm'   => 'Bu Aksesuar silmek istediğinizden emin misiniz?',
        'error'   => 'Aksesuarı silerken bir hata oluştu. Lütfen tekrar deneyin.',
        'success' => 'Aksesuar başarıyla silindi.'
    ),

     'checkout' => array(
        'error'   		=> 'Aksesuar çıkışı yapılamadı, lütfen tekrar deneyin',
        'success' 		=> 'Aksesuar çıkışı yapıldı.',
        'unavailable'   => 'Bu ürün zimmetlenemez. Ürün sayısını kontrol edin.',
        'user_does_not_exist' => 'Bu kullanıcı geçersiz. Lütfen tekrar deneyin.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Aksesuar girişi yapılamadı, lütfen tekrar deneyin',
        'success' 		=> 'Aksesuar girişi yapıldı.',
        'user_does_not_exist' => 'Bu kullanıcı geçersiz. Lütfen tekrar deneyin.'
    )


);
