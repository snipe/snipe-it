<?php

return array(

    'does_not_exist' => 'Model tidak ada.',
    'assoc_users'	 => 'Model ini saat ini dikaitkan dengan satu atau lebih aset dan tidak dapat dihapus. Harap hapus asetnya, lalu coba hapus lagi. ',


    'create' => array(
        'error'   => 'Model tidak dibuat, silahkan dicoba lagi.',
        'success' => 'Model berhasil dibuat.',
        'duplicate_set' => 'Model aset dengan nama, nama produsen dan nomor model yang sudah ada.',
    ),

    'update' => array(
        'error'   => 'Model tidak diperbarui, silahkan dicoba lagi',
        'success' => 'Model berhasil diperbarui.'
    ),

    'delete' => array(
        'confirm'   => 'Yakin ingin menghapus model aset ini?',
        'error'   => 'Terjadi masalah saat menghapus model. Silahkan coba lagi.',
        'success' => 'Model berhasil dihapus.'
    ),

    'restore' => array(
        'error'   		=> 'Aset tidak dikembalikan, coba lagi',
        'success' 		=> 'Model berhasil dikembalikan.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Tidak ada bidang yang berubah, jadi tidak ada yang diperbarui.',
        'success' 		=> 'Model diperbarui.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Tidak ada model yang dipilih, jadi tidak ada yang dihapus.',
        'success' 		    => ':success_count model(s) dihapus!',
        'success_partial' 	=> ':success_count model(s) telah dihapus, namun: fail_count tidak dapat dihapus karena mereka masih memiliki aset yang terkait dengannya.'
    ),

);
