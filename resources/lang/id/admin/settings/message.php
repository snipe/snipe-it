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
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Terdapat kesalahan ketika proses pembersihan. ',
        'validation_failed'     => 'Konfirmasi pembersihan anda tidak tepat. Silahkan ketikan kata "DELETE" di kotak konfirmasi.',
        'success'               => 'Sukses melakukan pembersihan data yang terhapus.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
    ]
];
