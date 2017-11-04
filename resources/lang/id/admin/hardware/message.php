<?php

return array(

    'undeployable' 		=> '<strong>Peringatan: </strong> Aset ini telah di tandai sebagai aset yang tak dapat digunakan.
                        Jika status ini telah berubah, silahkan perbarui status aset.',
    'does_not_exist' 	=> 'Aset tidak ada.',
    'does_not_exist_or_not_requestable' => 'Aset tersebut tidak terdaftar atau tidak dapat di minta.',
    'assoc_users'	 	=> 'Aset ini sudah diberikan kepada pengguna dan tidak dapat di hapus. Silahkan cek aset terlebih dahulu kemudian coba hapus kembali. ',

    'create' => array(
        'error'   		=> 'Aset gagal di buat, silahkan coba kembali',
        'success' 		=> 'Sukses membuat aset'
    ),

    'update' => array(
        'error'   			=> 'Gagal perbarui aset, silahkan coba kembali',
        'success' 			=> 'Sukses perbarui aset.',
        'nothing_updated'	=>  'Tidak ada kolom yang dipilih, jadi tidak ada yang diperbaharui.',
    ),

    'restore' => array(
        'error'   		=> 'Aset gagal dikembalikan, silahkan coba lagi',
        'success' 		=> 'Aset berhasil dikembalikan.'
    ),

    'audit' => array(
        'error'   		=> 'Audit aset tidak berhasil. Silahkan coba lagi',
        'success' 		=> 'Audit aset berhasil login.'
    ),


    'deletefile' => array(
        'error'   => 'Berkas tidak terhapus. Silahkan coba kembali.',
        'success' => 'Berkas berhasil dihapus.',
    ),

    'upload' => array(
        'error'   => 'Berkas gagal diunggah. Silahkan coba kembali.',
        'success' => 'Berkas berhasil diunggah.',
        'nofiles' => 'Anda belum memilih berkas untuk diunggah, atau berkas yang akan diunggah terlalu besar',
        'invalidfiles' => 'Satu atau beberapa berkas Anda terlalu besar atau termasuk tipe berkas yang tidak diizinkan. Berkas yang diperbolehkan adalah png, gif, jpg, doc, docx, pdf, dan txt.',
    ),

    'import' => array(
        'error'                 => 'Beberapa item tidak terimpor dengan benar.',
        'errorDetail'           => 'Item berikut tidak terimpor karena ada kesalahan.',
        'success'               => "Berkas Anda berhasil terimpor",
        'file_delete_success'   => "File anda telah berhasil dihapus",
        'file_delete_error'      => "File tidak bisa dihapus",
    ),


    'delete' => array(
        'confirm'   	=> 'Apakah Anda yakin untuk menghapus aset ini?',
        'error'   		=> 'Terdapat kesalahan pada saat penghapusan aset. Silahkan coba kembali.',
        'nothing_updated'   => 'Tidak ada aset yang dipilih, jadi tidak ada yang dihapus.',
        'success' 		=> 'Aset sukses terhapus.'
    ),

    'checkout' => array(
        'error'   		=> 'Aset gagal di berikan, silahkan coba kembali',
        'success' 		=> 'Sukses memberikan aset.',
        'user_does_not_exist' => 'Pengguna tersebut tidak terdaftar. Silahkan coba kembali.',
        'not_available' => 'Aset tersebut tidak tersedia untuk checkout!',
        'no_assets_selected' => 'You must select at least one asset from the list'
    ),

    'checkin' => array(
        'error'   		=> 'Aset gagal di terima, silahkan coba kembali',
        'success' 		=> 'Sukses menerima aset.',
        'user_does_not_exist' => 'Pengguna tersebut tidak terdaftar. Silahkan coba kembali.',
        'already_checked_in'  => 'Aset tersebut telah di terima.',

    ),

    'requests' => array(
        'error'   		=> 'Aset gagal di minta, silahkan coba kembali',
        'success' 		=> 'Sukses meminta aset.',
        'canceled'      => 'Permintaan pemeriksaan berhasil dibatalkan'
    )

);
