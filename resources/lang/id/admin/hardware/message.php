<?php

return [

    'undeployable' 		=> '<strong>Peringatan: </strong> Aset ini telah di tandai sebagai aset yang tak dapat digunakan.
                        Jika status ini telah berubah, silahkan perbarui status aset.',
    'does_not_exist' 	=> 'Aset tidak ada.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Aset ini sudah diberikan kepada pengguna dan tidak dapat di hapus. Silahkan cek aset terlebih dahulu kemudian coba hapus kembali. ',

    'create' => [
        'error'   		=> 'Aset gagal di buat, silahkan coba kembali',
        'success' 		=> 'Sukses membuat aset',
    ],

    'update' => [
        'error'   			=> 'Gagal perbarui aset, silahkan coba kembali',
        'success' 			=> 'Sukses perbarui aset.',
        'nothing_updated'	=>  'Tidak ada kolom yang dipilih, jadi tidak ada yang diperbaharui.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Aset gagal dikembalikan, silahkan coba lagi',
        'success' 		=> 'Aset berhasil dikembalikan.',
    ],

    'audit' => [
        'error'   		=> 'Audit aset tidak berhasil. Silahkan coba lagi',
        'success' 		=> 'Audit aset berhasil login.',
    ],


    'deletefile' => [
        'error'   => 'Berkas tidak terhapus. Silahkan coba kembali.',
        'success' => 'Berkas berhasil dihapus.',
    ],

    'upload' => [
        'error'   => 'Berkas gagal diunggah. Silahkan coba kembali.',
        'success' => 'Berkas berhasil diunggah.',
        'nofiles' => 'Anda belum memilih berkas untuk diunggah, atau berkas yang akan diunggah terlalu besar',
        'invalidfiles' => 'Satu atau beberapa berkas Anda terlalu besar atau termasuk tipe berkas yang tidak diizinkan. Berkas yang diperbolehkan adalah png, gif, jpg, doc, docx, pdf, dan txt.',
    ],

    'import' => [
        'error'                 => 'Beberapa item tidak terimpor dengan benar.',
        'errorDetail'           => 'Item berikut tidak terimpor karena ada kesalahan.',
        'success'               => 'Berkas Anda berhasil terimpor',
        'file_delete_success'   => 'File anda telah berhasil dihapus',
        'file_delete_error'      => 'File tidak bisa dihapus',
    ],


    'delete' => [
        'confirm'   	=> 'Apakah Anda yakin untuk menghapus aset ini?',
        'error'   		=> 'Terdapat kesalahan pada saat penghapusan aset. Silahkan coba kembali.',
        'nothing_updated'   => 'Tidak ada aset yang dipilih, jadi tidak ada yang dihapus.',
        'success' 		=> 'Aset sukses terhapus.',
    ],

    'checkout' => [
        'error'   		=> 'Aset gagal di berikan, silahkan coba kembali',
        'success' 		=> 'Sukses memberikan aset.',
        'user_does_not_exist' => 'Pengguna tersebut tidak terdaftar. Silahkan coba kembali.',
        'not_available' => 'Aset tersebut tidak tersedia untuk checkout!',
        'no_assets_selected' => 'Anda harus memilih setidaknya satu aset dari daftar',
    ],

    'checkin' => [
        'error'   		=> 'Aset gagal di terima, silahkan coba kembali',
        'success' 		=> 'Sukses menerima aset.',
        'user_does_not_exist' => 'Pengguna tersebut tidak terdaftar. Silahkan coba kembali.',
        'already_checked_in'  => 'Aset tersebut telah di terima.',

    ],

    'requests' => [
        'error'   		=> 'Aset gagal di minta, silahkan coba kembali',
        'success' 		=> 'Sukses meminta aset.',
        'canceled'      => 'Permintaan pemeriksaan berhasil dibatalkan',
    ],

];
