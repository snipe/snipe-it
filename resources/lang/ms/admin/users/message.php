<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Pengguna telah wujud!',
    'user_not_found'            => 'Pengguna [:id] tidak wujud.',
    'user_login_required'       => 'Ruangan log masuk diperlukan',
    'user_password_required'    => 'Ruangan kata kunci diperlukan.',
    'insufficient_permissions'  => 'Tidak cukup kuasa.',
    'user_deleted_warning'      => 'Pengguna telah dihapuskan. Anda perlu masukkan semula pengguna ini untuk kemaskini atau untuk serahkan dia harta baru.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'Pengguna berjaya dicipta.',
        'update'    => 'Pengguna berjaya dikemaskini.',
        'delete'    => 'Pnegguna berjaya dihapuskan.',
        'ban'       => 'Pengguna berjaya disekat.',
        'unban'     => 'Pengguna berjaya dibernarkan.',
        'suspend'   => 'Pengguna berjaya digantung.',
        'unsuspend' => 'Pengguna berjaya dilepaskan.',
        'restored'  => 'Pengguna berjaya dimasukkan semula.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'Ada isu semasa mencipta pengguna. Sila cuba lagi.',
        'update' => 'Ada isu semasa mencipta pengguna. Sila cuba lagi.',
        'delete' => 'Ada isu semasa menghapuskan pengguna. Sila cuba lagi.',
        'unsuspend' => 'Ada isu semasa melepakan pengguna. Sila cuba lagi. ',
        'import'    => 'There was an issue importing users. Please try again.',
        'asset_already_accepted' => 'This asset has already been accepted.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);
