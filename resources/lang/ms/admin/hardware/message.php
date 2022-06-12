<?php

return [

    'undeployable' 		=> '<strong>Amaran: </strong> Aset ini telah ditandakan sebagai tidak boleh dikehendaki. Jika status ini telah berubah, sila kemas kini status aset.',
    'does_not_exist' 	=> 'Harta tidak wujud.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Harta ini sekarang telah diagihkan kepada pengguna dan tidak boleh dihapuskan. Sila semak status harta ini dahulu, dan kemudian cuba semula. ',

    'create' => [
        'error'   		=> 'Harta gagal dicipta, sila cuba semula. :(',
        'success' 		=> 'Harta berjaya dicipta. :)',
    ],

    'update' => [
        'error'   			=> 'Harta gagal dikemaskini, sila cuba semula',
        'success' 			=> 'Harta berjaya dikemaskini.',
        'nothing_updated'	=>  'Tiada medan dipilih, jadi tiada apa yang dikemas kini.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Aset tidak dipulihkan, sila cuba lagi',
        'success' 		=> 'Aset dipulihkan dengan jayanya.',
    ],

    'audit' => [
        'error'   		=> 'Audit aset tidak berjaya. Sila cuba lagi.',
        'success' 		=> 'Audit aset berjaya log.',
    ],


    'deletefile' => [
        'error'   => 'Fail tidak dipadam. Sila cuba lagi.',
        'success' => 'Fail berjaya dipadam.',
    ],

    'upload' => [
        'error'   => 'Fail tidak dimuat naik. Sila cuba lagi.',
        'success' => 'Fail berjaya dimuat naik.',
        'nofiles' => 'Anda tidak memilih sebarang fail untuk dimuat naik, atau fail yang anda cuba muat naik terlalu besar',
        'invalidfiles' => 'Satu atau lebih daripada fail anda terlalu besar atau merupakan filetype yang tidak dibenarkan. Filetype yang dibenarkan adalah png, gif, jpg, doc, docx, pdf, dan txt.',
    ],

    'import' => [
        'error'                 => 'Sesetengah item tidak diimport dengan betul.',
        'errorDetail'           => 'Item berikut tidak diimport kerana kesilapan.',
        'success'               => 'Fail anda telah diimport',
        'file_delete_success'   => 'Fail anda telah berjaya dihapuskan',
        'file_delete_error'      => 'Fail tidak dapat dipadamkan',
    ],


    'delete' => [
        'confirm'   	=> 'Anda pasti anda ingin hapuskan harta ini?',
        'error'   		=> 'Ada isu semasa menghapuskan harta. Sila cuba lagi.',
        'nothing_updated'   => 'Tiada aset dipilih, jadi tiada apa yang dipadamkan.',
        'success' 		=> 'Harta berjaya dihapuskan.',
    ],

    'checkout' => [
        'error'   		=> 'Harta gagal diagihkan, sila cuba semula',
        'success' 		=> 'Harta berjaya diagihkan.',
        'user_does_not_exist' => 'Pengguna tak sah. Sila cuba lagi.',
        'not_available' => 'Aset itu tidak tersedia untuk checkout!',
        'no_assets_selected' => 'Anda mesti memilih sekurang-kurangnya satu aset dari senarai',
    ],

    'checkin' => [
        'error'   		=> 'Harta tidak diterima, sila cuba lagi',
        'success' 		=> 'Harta berjaya diterima.',
        'user_does_not_exist' => 'Pengguna tidah sah. Sila cuba lagi.',
        'already_checked_in'  => 'Aset itu sudah diperiksa.',

    ],

    'requests' => [
        'error'   		=> 'Aset tidak diminta, sila cuba lagi',
        'success' 		=> 'Aset diminta berjaya.',
        'canceled'      => 'Permintaan keluar telah dibatalkan',
    ],

];
