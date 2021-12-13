<?php

return array(

    'accepted'                  => 'Anda telah berjaya menerima aset ini.',
    'declined'                  => 'Anda telah berjaya menolak aset ini.',
    'bulk_manager_warn'	        => 'Pengguna anda telah berjaya dikemas kini, namun entri pengurus anda tidak disimpan kerana pengurus yang anda pilih juga dalam senarai pengguna untuk diedit, dan pengguna mungkin bukan pengurus mereka sendiri. Sila pilih pengguna anda sekali lagi, tidak termasuk pengurus.',
    'user_exists'               => 'Pengguna telah wujud!',
    'user_not_found'            => 'Pengguna [:id] tidak wujud.',
    'user_login_required'       => 'Ruangan log masuk diperlukan',
    'user_password_required'    => 'Ruangan kata kunci diperlukan.',
    'insufficient_permissions'  => 'Tidak cukup kuasa.',
    'user_deleted_warning'      => 'Pengguna telah dihapuskan. Anda perlu masukkan semula pengguna ini untuk kemaskini atau untuk serahkan dia harta baru.',
    'ldap_not_configured'        => 'Integrasi LDAP belum dikonfigurasi untuk pemasangan ini.',
    'password_resets_sent'      => 'The selected users who are activated and have a valid email addresses have been sent a password reset link.',
    'password_reset_sent'       => 'A password reset link has been sent to :email!',


    'success' => array(
        'create'    => 'Pengguna berjaya dicipta.',
        'update'    => 'Pengguna berjaya dikemaskini.',
        'update_bulk'    => 'Pengguna berjaya dikemas kini!',
        'delete'    => 'Pnegguna berjaya dihapuskan.',
        'ban'       => 'Pengguna berjaya disekat.',
        'unban'     => 'Pengguna berjaya dibernarkan.',
        'suspend'   => 'Pengguna berjaya digantung.',
        'unsuspend' => 'Pengguna berjaya dilepaskan.',
        'restored'  => 'Pengguna berjaya dimasukkan semula.',
        'import'    => 'Pengguna diimport dengan jayanya.',
    ),

    'error' => array(
        'create' => 'Ada isu semasa mencipta pengguna. Sila cuba lagi.',
        'update' => 'Ada isu semasa mencipta pengguna. Sila cuba lagi.',
        'delete' => 'Ada isu semasa menghapuskan pengguna. Sila cuba lagi.',
        'delete_has_assets' => 'Pengguna ini mempunyai item yang ditetapkan dan tidak dapat dipadamkan.',
        'unsuspend' => 'Ada isu semasa melepakan pengguna. Sila cuba lagi. ',
        'import'    => 'Terdapat masalah mengimport pengguna. Sila cuba lagi.',
        'asset_already_accepted' => 'Aset ini telah diterima.',
        'accept_or_decline' => 'Anda mesti menerima atau menolak aset ini.',
        'incorrect_user_accepted' => 'Aset yang anda telah cuba terima tidak diperiksa kepada anda.',
        'ldap_could_not_connect' => 'Tidak dapat menyambung ke pelayan LDAP. Sila periksa konfigurasi pelayan LDAP anda dalam fail konfigurasi LDAP. <br>Error dari LDAP Server:',
        'ldap_could_not_bind' => 'Tidak dapat mengikat pelayan LDAP. Sila periksa konfigurasi pelayan LDAP anda dalam fail konfigurasi LDAP. <br>Error dari LDAP Server:',
        'ldap_could_not_search' => 'Tidak dapat mencari pelayan LDAP. Sila periksa konfigurasi pelayan LDAP anda dalam fail konfigurasi LDAP. <br>Error dari LDAP Server:',
        'ldap_could_not_get_entries' => 'Tidak dapat masuk dari pelayan LDAP. Sila periksa konfigurasi pelayan LDAP anda dalam fail konfigurasi LDAP. <br>Error dari LDAP Server:',
        'password_ldap' => 'Kata laluan untuk akaun ini diuruskan oleh LDAP / Active Directory. Sila hubungi jabatan IT anda untuk menukar kata laluan anda.',
    ),

    'deletefile' => array(
        'error'   => 'Fail tidak dipadam. Sila cuba lagi.',
        'success' => 'Fail berjaya dipadam.',
    ),

    'upload' => array(
        'error'   => 'Fail tidak dimuat naik. Sila cuba lagi.',
        'success' => 'Fail berjaya dimuat naik.',
        'nofiles' => 'Anda tidak memilih sebarang fail untuk dimuat naik',
        'invalidfiles' => 'Satu atau lebih daripada fail anda terlalu besar atau merupakan filetype yang tidak dibenarkan. Filetype yang dibenarkan adalah png, gif, jpg, doc, docx, pdf, dan txt.',
    ),

);
