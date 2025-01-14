<?php

return [

    'update' => [
        'error'                 => 'Terdapat kesalahan ketika proses pembaharuan. ',
        'success'               => 'Sukses perbarui pengaturan.',
    ],
    'backup' => [
        'delete_confirm'        => 'Apakah anda yakin menghapus berkas cadangan ini? Tindakan ini tidak dapat di batalkan. ',
        'file_deleted'          => 'Sukses menghapus Berkas cadangan. ',
        'generated'             => 'Sukses membuat cadangan baru.',
        'file_not_found'        => 'Berkas cadangan tidak ditemukan di server.',
        'restore_warning'       => 'Ya, pulihkan. Saya mengerti bahwa ini akan menimpa data yang ada saat ini di database. Ini juga akan mengeluarkan semua pengguna yang ada (termasuk Anda).',
        'restore_confirm'       => 'Apakah Anda yakin ingin memulihkan database Anda dari :filename?'
    ],
    'restore' => [
        'success'               => 'Cadangan sistem Anda telah dipulihkan. Silakan masuk kembali.'
    ],
    'purge' => [
        'error'     => 'Terdapat kesalahan ketika proses pembersihan. ',
        'validation_failed'     => 'Konfirmasi pembersihan anda tidak tepat. Silahkan ketikan kata "DELETE" di kotak konfirmasi.',
        'success'               => 'Sukses melakukan pembersihan data yang terhapus.',
    ],
    'mail' => [
        'sending' => 'Mengirim Email Uji...',
        'success' => 'Email terkirim!',
        'error' => 'Email gagal dikirim.',
        'additional' => 'Tidak ada pesan kesalahan tambahan yang diberikan. Periksa pengaturan email dan log aplikasi Anda.'
    ],
    'ldap' => [
        'testing' => 'Menguji Koneksi, Pengikatan & Kueri LDAP...',
        '500' => 'Kesalahan Server 500. Silakan periksa log server Anda untuk informasi lebih lanjut.',
        'error' => 'Terjadi kesalahan :(',
        'sync_success' => 'Contoh 10 pengguna yang dikembalikan dari server LDAP berdasarkan pengaturan Anda:',
        'testing_authentication' => 'Menguji Autentikasi LDAP...',
        'authentication_success' => 'Pengguna berhasil diautentikasi terhadap LDAP!'
    ],
    'webhook' => [
        'sending' => 'Mengirim pesan uji :app...',
        'success' => 'Integrasi :webhook_name Anda berfungsi!',
        'success_pt1' => 'Berhasil! Periksa ',
        'success_pt2' => ' saluran untuk pesan uji Anda, dan pastikan untuk mengklik SIMPAN di bawah untuk menyimpan pengaturan Anda.',
        '500' => 'Kesalahan Server 500.',
        'error' => 'Terjadi kesalahan. :app merespons dengan: :error_message',
        'error_redirect' => 'KESALAHAN: 301/302 :endpoint mengembalikan pengalihan. Untuk alasan keamanan, kami tidak mengikuti pengalihan. Harap gunakan endpoint yang sebenarnya.',
        'error_misc' => 'Terjadi kesalahan. :( ',
    ]
];
