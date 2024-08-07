<?php

return array(

    'does_not_exist' => 'Aksesori [:id] tidak ada.',
    'not_found' => 'That accessory was not found.',
    'assoc_users'	 => 'Aksesori ini saat ini memiliki: count item yang dikeluarkan ke pengguna. Silakan periksa di aksesoris dan dan coba lagi. . Silakan periksa di aksesoris dan dan coba lagi. ',

    'create' => array(
        'error'   => 'Aksesori gagal di buat, mohon ulangi kembali.',
        'success' => 'Aksesori sukses di buat.'
    ),

    'update' => array(
        'error'   => 'Aksesori gagal terbaharui, mohon ulangi kembali',
        'success' => 'Aksesori sukses terbaharui.'
    ),

    'delete' => array(
        'confirm'   => 'Apakah anda yakin menghapus aksesori ini?',
        'error'   => 'Terdapat kesalahan pada saat penghapusan aksesori ini. Silahkan coba kembali.',
        'success' => 'Aksesori sukses terhapus.'
    ),

     'checkout' => array(
        'error'   		=> 'Aksesori ini belum dikeluarkan, silahkan coba kembali',
        'success' 		=> 'Aksesori telah berhasil dikeluarkan.',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'Terdapat kesalahan pada user ini. Silahkan coba kembali.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Aksesoris belum masuk, silahkan coba kembali',
        'success' 		=> 'Aksesoris telah berhasil dimasukkan.',
        'user_does_not_exist' => 'Terdapat kesalahan pada user ini. Silahkan coba kembali.'
    )


);
