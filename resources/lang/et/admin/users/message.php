<?php

return array(

    'accepted'                  => 'Oled selle vahendi edukalt vastu võtnud.',
    'declined'                  => 'Oled selle vahendi tagasi lükanud.',
    'bulk_manager_warn'	        => 'Sinu kasutajad on edukalt muudetud, kuid sinu juhi-kirjet ei salvestatud sest juht, kelle valisid oli ka muudatavate kasutajate hulgas ning kasutaja ei või olla ise-enda juht. Palun vali oma kasutajad uuesti, jättes juhi kõrvale.',
    'user_exists'               => 'Kasutaja on juba olemas!',
    'user_not_found'            => 'Kasutajat [:id] ei ole olemas.',
    'user_login_required'       => 'Login väli on kohustuslik',
    'user_password_required'    => 'Parooli väli on kohustuslik.',
    'insufficient_permissions'  => 'Ebapiisavad õigused.',
    'user_deleted_warning'      => 'See kasutaja on kustutatud. Et kasutajat muuta või talle uusi vahendeid anda, pead ta esmalt taastama.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'Kasutaja loomine õnnestus.',
        'update'    => 'Kasutaja uuendamine õnnestus.',
        'update_bulk'    => 'Kasutajate uuendamine õnnestus!',
        'delete'    => 'Kasutaja kustutamine õnnestus.',
        'ban'       => 'Kasutaja bännimine õnnestus.',
        'unban'     => 'Kasutaja de-bännimine õnnestus.',
        'suspend'   => 'Kasutaja ajutine peatamine õnnestus.',
        'unsuspend' => 'User was successfully unsuspended.',
        'restored'  => 'Kasutaja taastamine õnnestus.',
        'import'    => 'Kasutajate importimine õnnestus.',
    ),

    'error' => array(
        'create' => 'Kasutaja loomisel tekkis probleem. Palun proovi uuesti.',
        'update' => 'Kasutaja uuendamisel tekkis probleem. Palun proovi uuesti.',
        'delete' => 'Kasutaja kustutamisel tekkis probleem. Palun proovi uuesti.',
        'delete_has_assets' => 'This user has items assigned and could not be deleted.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'import'    => 'Kasutajate importimisel tekkis probleem. Palun proovi uuesti.',
        'asset_already_accepted' => 'See vahend on juba vastu võetud.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'password_ldap' => 'The password for this account is managed by LDAP/Active Directory. Please contact your IT department to change your password. ',
    ),

    'deletefile' => array(
        'error'   => 'Faili ei kustustatud. Palun proovi uuesti.',
        'success' => 'Fail kustutati.',
    ),

    'upload' => array(
        'error'   => 'Fail(e) ei laetud üles. Palun proovi uuesti.',
        'success' => 'Fail(id) laeti edukalt üles.',
        'nofiles' => 'Sa ei valinud üles laadimiseks ühtegi faili',
        'invalidfiles' => 'Üks või mitu sibu failidest on kas liigas uured või ei ole lubatud tüüpi. Lobatud tüübid on png, gif, jpg, doc, docx, pdf, ja txt.',
    ),

);
