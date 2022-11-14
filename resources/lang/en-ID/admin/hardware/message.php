<?php

return [

    'undeployable' 		=> '<strong>Peringatan:</strong>Aset ini telah ditandai karena saat ini tidak dapat dipasangkan lagi. Jika status ini telah berubah, harap perbarui status aset.',
    'does_not_exist' 	=> 'Aset tidak ada.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Aset ini saat ini diperiksa ke pengguna dan tidak dapat dihapus. Harap periksa dulu asetnya, lalu coba hapus lagi. ',

    'create' => [
        'error'   		=> 'Aset tidak dibuat, coba lagi. :(',
        'success' 		=> 'Aset berhasil dibuat. :)',
    ],

    'update' => [
        'error'   			=> 'Aset tidak diperbarui, coba lagi',
        'success' 			=> 'Aset Berhasil diperbarui.',
        'nothing_updated'	=>  'Tidak ada kategori yang dipilih, jadi tidak ada yang diperbarui.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Aset tidak dikembalikan, coba lagi',
        'success' 		=> 'Aset Berhasil dikembalikan.',
    ],

    'audit' => [
        'error'   		=> 'Audit aset tidak berhasil. Silahkan coba lagi.',
        'success' 		=> 'Audit aset berhasil dimasuki.',
    ],


    'deletefile' => [
        'error'   => 'Berkas tidak terhapus. Silahkan coba lagi.',
        'success' => 'File berhasil dihapus.',
    ],

    'upload' => [
        'error'   => 'Berkas(s) tidak diunggah. Silahkan coba lagi.',
        'success' => 'Berkas(s) berhasil diunggah.',
        'nofiles' => 'Anda tidak memilih file untuk diunggah, atau file yang ingin Anda unggah terlalu besar',
        'invalidfiles' => 'Satu atau lebih berkas anda terlalu besar atau jenis berkas tidak dibolehkan. Jenis berkas yang dibolehkan adalah png, gif, jpg, doc, docx, pdf, dan txt.',
    ],

    'import' => [
        'error'                 => 'Beberapa item tidak diimpor dengan benar.',
        'errorDetail'           => 'Item berikut tidak diimpor karena kesalahan.',
        'success'               => 'File Anda telah diimpor',
        'file_delete_success'   => 'File anda telah berhasil dihapus',
        'file_delete_error'      => 'File tidak dapat dihapus',
    ],


    'delete' => [
        'confirm'   	=> 'Yakin ingin menghapus aset ini?',
        'error'   		=> 'Terjadi masalah saat menghapus aset. Silahkan coba lagi.',
        'nothing_updated'   => 'Tidak ada aset yang dipilih, jadi tidak ada yang diperbarui.',
        'success' 		=> 'Aset berhasil dihapus.',
    ],

    'checkout' => [
        'error'   		=> 'Aset tidak dapat diperiksa, silahkan coba lagi',
        'success' 		=> 'Aset berhasil diperiksa.',
        'user_does_not_exist' => 'Pengguna tidak cocok. Silahkan coba lagi.',
        'not_available' => 'Aset itu tersebut tidak tersedia untuk checkout!',
        'no_assets_selected' => 'Anda harus memilih setidaknya satu aset dari daftar',
    ],

    'checkin' => [
        'error'   		=> 'Aset tidak dicek, coba lagi',
        'success' 		=> 'Aset berhasil dicek.',
        'user_does_not_exist' => 'Pengguna tidak cocok. Silahkan coba lagi.',
        'already_checked_in'  => 'Aset tersebut sudah diperiksa.',

    ],

    'requests' => [
        'error'   		=> 'Aset tidak dikembalikan, coba lagi',
        'success' 		=> 'Aset Berhasil dikembalikan.',
        'canceled'      => 'Permintaan checkout berhasil dibatalkan',
    ],

];
