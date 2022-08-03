<?php

return array(

<<<<<<< HEAD
    'deleted' => 'Deleted asset model',
    'does_not_exist' => 'Model tidak ada.',
    'no_association' => 'WARNING! The asset model for this item is invalid or missing!',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Model ini saat ini dikaitkan dengan satu atau lebih aset dan tidak dapat dihapus. Harap hapus asetnya, lalu coba hapus lagi. ',
    'invalid_category_type' => 'The category must be an asset category.',
=======
    'does_not_exist' => 'Model tidak ada.',
    'assoc_users'	 => 'Model ini saat ini dikaitkan dengan satu atau lebih aset dan tidak dapat dihapus. Harap hapus asetnya, lalu coba hapus lagi. ',

>>>>>>> 64747d0fb (updates based on review)

    'create' => array(
        'error'   => 'Model tidak dibuat, silahkan dicoba lagi.',
        'success' => 'Model berhasil dibuat.',
        'duplicate_set' => 'Model aset dengan nama, nama produsen dan nomor model yang sudah ada.',
    ),

    'update' => array(
        'error'   => 'Model tidak diperbarui, silahkan dicoba lagi',
<<<<<<< HEAD
        'success' => 'Model berhasil diperbarui.',
=======
        'success' => 'Model berhasil diperbarui.'
>>>>>>> 64747d0fb (updates based on review)
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
<<<<<<< HEAD
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properties of the following model:|You are about to edit the properties of the following :model_count models:',

=======
        'success' 		=> 'Model diperbarui.'
>>>>>>> 64747d0fb (updates based on review)
    ),

    'bulkdelete' => array(
        'error'   		    => 'Tidak ada model yang dipilih, jadi tidak ada yang dihapus.',
<<<<<<< HEAD
        'success' 		    => 'Model deleted!|:success_count models deleted!',
=======
        'success' 		    => ':success_count model(s) dihapus!',
>>>>>>> 64747d0fb (updates based on review)
        'success_partial' 	=> ':success_count model(s) telah dihapus, namun: fail_count tidak dapat dihapus karena mereka masih memiliki aset yang terkait dengannya.'
    ),

);
