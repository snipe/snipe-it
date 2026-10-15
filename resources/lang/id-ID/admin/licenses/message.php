<?php

return [

    'does_not_exist' => 'Lisensi tidak ada atau Anda tidak memiliki izin untuk melihatnya.',
    'user_does_not_exist' => 'Pengguna tidak ada atau Anda tidak memiliki izin untuk melihatnya.',
    'asset_does_not_exist' => 'Aset yang hendak di asosiasikan dengan lisensi ini tidak ada.',
    'owner_doesnt_match_asset' => 'Aset yang hendak di asosiasikan dengan lisensi ini di miliki oleh seseorang yang tidak masuk dalam daftar.',
    'assoc_users' => 'Lisensi ini sudah diberikan kepada pengguna dan tidak dapat di hapus. Silahkan cek lisensi terlebih dahulu kemudian coba hapus kembali. ',
    'select_asset_or_person' => 'Anda harus memilih aset atau pengguna, namun tidak keduanya.',
    'not_found' => 'Berkas Lisensi tidak ditemukan',
    'seats_available' => ':seat_count slot lisensi tersedia',

    'create' => [
        'error' => 'Gagal membuat lisensi, silahkan coba kembali.',
        'success' => 'Sukses membuat lisensi.',
    ],

    'deletefile' => [
        'error' => 'Berkas belum terhapus. Silahkan coba kembali.',
        'success' => 'Berkas sukses di hapus.',
    ],

    'upload' => [
        'error' => 'Berkas belum terunggah. Silakan coba kembali.',
        'success' => 'Berkas sukses terunggah.',
        'nofiles' => 'Anda belum memilih berkas untuk di unggah, atau berkas yang akan di unggah terlalu besar ukurannya',
        'invalidfiles' => 'Satu atau lebih file Anda terlalu besar atau merupakan jenis filetype yang tidak diizinkan. Filetype yang diperbolehkan adalah png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml, dan lic.',
    ],

    'update' => [
        'error' => 'Gagal memperbarui lisensi, silahkan coba kembali',
        'success' => 'Sukses perbarui lisensi.',
    ],

    'delete' => [
        'confirm' => 'Apakah Anda yakin untuk menghapus lisensi ini?',
        'error' => 'Terdapat kesalahan pada saat penghapusan lisensi ini. Silahkan coba kembali.',
        'success' => 'Lisensi telah berhasil dihapus.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'Terdapat kesalahan pada saat pemberian lisensi ini. Silahkan coba kembali.',
        'success' => 'Lisensi telah berhasil diberikan',
        'not_enough_seats' => 'Jumlah slot lisensi yang tersedia tidak mencukupi untuk dipinjam atau diambil',
        'mismatch' => 'Slot lisensi yang diberikan tidak cocok dengan lisensi',
        'unavailable' => 'Slot lisensi ini tidak tersedia untuk dipinjam atau diambil.',
        'license_is_inactive' => 'Lisensi ini telah kadaluarsa atau dihentikan.',
    ],

    'checkin' => [
        'error' => 'Terdapat kesalahan pada saat penerimaan lisensi ini. Silahkan coba kembali.',
        'not_reassignable' => 'Tempat sudah digunakan',
        'success' => 'Lisensi telah berhasil diterima',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];
