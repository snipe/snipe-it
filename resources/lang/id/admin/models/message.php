<?php

return array(

    'does_not_exist' => 'Model tidak ada.',
    'assoc_users'	 => 'Saat ini model tersebut terhubung dengan 1 atau lebih dengan aset dan tidak dapat di hapus. Silahkan hapus aset terlebih dahulu, kemudian coba hapus kembali. ',


    'create' => array(
        'error'   => 'Model gagal di buat, silahkan coba kembali.',
        'success' => 'Sukses mebuat model.',
        'duplicate_set' => 'Model aset dengan nomor nama, produsen dan model yang sama sudah ada.',
    ),

    'update' => array(
        'error'   => 'Model gagal diperbarui, silahkan coba kembali',
        'success' => 'Sukses memperbarui Model.'
    ),

    'delete' => array(
        'confirm'   => 'Anda yakin untuk menghapus model aset ini?',
        'error'   => 'Terdapat kesalahan pada saat penghapusan model. Silahkan coba kembali.',
        'success' => 'Model sukses terhapus.'
    ),

    'restore' => array(
        'error'   		=> 'Modal gagal di pulihkan, silahkan coba kembali',
        'success' 		=> 'Sukses memulihkan model.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Tidak ada bidang yang berubah, jadi tidak ada yang diperbarui.',
        'success' 		=> 'Model diperbarui'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Tidak ada model yang dipilih, jadi tidak ada yang dihapus.',
        'success' 		    => ':success_count model dihapus!',
        'success_partial' 	=> ':success_count model telah dihapus, tetapi :fail_count tidak dapat dihapus karena masih memiliki aset yang terkait dengannya.'
    ),

);
