<?php

return [

    'does_not_exist' => 'Kategori tidak ada.',
    'assoc_models' => 'Kategori ini saat ini dikaitkan dengan setidaknya satu model dan tidak dapat dihapus. Perbarui model Anda yang tidak ada referensi dari kategori ini dan coba lagi. ',
    'assoc_items' => 'Kategori ini saat ini dikaitkan dengan setidaknya satu model dan tidak dapat dihapus. Perbarui model Anda yang tidak ada referensi dari kategori ini dan coba lagi. ',

    'create' => [
        'error' => 'Kategori belum terbuat, silahkan coba kembali.',
        'success' => 'Kategori telah berhasil dibuat.',
    ],

    'update' => [
        'error' => 'Pembaharuan kategori tidak berhasil, silahkan coba kembali',
        'success' => 'Pembaharuan kategori berhasil.',
        'cannot_change_category_type' => 'Anda tidak dapat mengubah jenis kategori setelah dibuat',
    ],

    'delete' => [
        'confirm' => 'Apakah Anda yakin untuk menghapus kategori ini?',
        'error' => 'Terdapat kesalahan pada saat penghapusan kategori ini. Silahkan coba kembali.',
        'success' => 'Kategori berhasil dihapus.',
        'bulk_success' => 'Category deleted successfully.|:count categories were deleted successfully.',
        'partial_success' => 'Kategori berhasil dihapus. Lihat info tambahan dibawah. | :count katergori berhasil dihapus. Lihat info tambahan dibawah.',
    ],

    'bulkedit' => [
        'warn' => 'You are about to edit the properties of the following category:|You are about to edit the properties of the following :count categories:',
        'no_selection' => 'You must select at least one category to edit.',
        'no_changes' => 'Tidak ada bidang yang berubah, jadi tidak ada yang diperbarui.',
        'success' => 'Category successfully updated.|:count categories successfully updated.',
    ],

];
