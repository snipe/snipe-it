<?php

return array(

    'does_not_exist' => 'Lokasi tidak ada.',
<<<<<<< HEAD
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this company and try again. ',
    'assoc_assets'	 => 'Saat ini kategori ini terkait dengan setidaknya satu pengguna dan tidak dapat dihapus. Silahkan perbaharui pengguna anda untuk tidak lagi tereferensi dengan kategori ini dan coba lagi. ',
    'assoc_child_loc'	 => 'Lokasi ini saat ini merupakan induk dari setidaknya satu lokasi anak dan tidak dapat dihapus. Perbarui lokasi Anda agar tidak lagi merujuk lokasi ini dan coba lagi. ',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',
=======
    'assoc_users'	 => 'Saat ini kategori ini terkait dengan setidaknya satu pengguna dan tidak dapat dihapus. Silahkan perbaharui pengguna anda untuk tidak lagi tereferensi dengan kategori ini dan coba lagi. ',
    'assoc_assets'	 => 'Saat ini kategori ini terkait dengan setidaknya satu pengguna dan tidak dapat dihapus. Silahkan perbaharui pengguna anda untuk tidak lagi tereferensi dengan kategori ini dan coba lagi. ',
    'assoc_child_loc'	 => 'Lokasi ini saat ini merupakan induk dari setidaknya satu lokasi anak dan tidak dapat dihapus. Perbarui lokasi Anda agar tidak lagi merujuk lokasi ini dan coba lagi. ',
>>>>>>> 64747d0fb (updates based on review)


    'create' => array(
        'error'   => 'Lokasi tidak dibuat, coba lagi.',
        'success' => 'Lokasi berhasil dibuat.'
    ),

    'update' => array(
        'error'   => 'Lokasi tidak diperbarui, silakan coba lagi',
        'success' => 'Lokasi berhasil diperbarui.'
    ),

    'delete' => array(
        'confirm'   	=> 'Apakah anda yakin ingin menghapus lokasi ini?',
        'error'   => 'Terjadi masalah saat menghapus lokasi. Silahkan coba lagi.',
        'success' => 'Lokasi telah berhasil dihapus.'
    )

);
