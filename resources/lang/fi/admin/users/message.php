<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Käyttäjää on jo luotu!',
    'user_not_found'            => 'Käyttäjää [:id] ei löydy.',
    'user_login_required'       => 'Käyttäjätunnus vaaditaan',
    'user_password_required'    => 'Salasana vaaditaan.',
    'insufficient_permissions'  => 'Riittämättömät Oikeudet.',
    'user_deleted_warning'      => 'Käyttäjä on jo poistettu. Mikäli haluat muokata tai luovuttaa laitteita hänelle sinun tulee palauttaa käyttäjä.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'Käyttäjä luotiin onnistuneesti.',
        'update'    => 'Käyttäjä päivitettiin onnistuneesti.',
        'delete'    => 'Käyttäjä poistettiin onnistuneesti.',
        'ban'       => 'Käyttäjä estettiin onnistuneesti.',
        'unban'     => 'Käyttäjän esto poistettiin onnistuneesti.',
        'suspend'   => 'Käyttäjä jäädytettiin onnistuneesti.',
        'unsuspend' => 'Käyttäjän jäädytys poistettiin onnistuneesti.',
        'restored'  => 'Käyttäjä palautettiin onnistuneesti.',
        'import'    => 'Käyttäjät tuotiin onnistuneesti.',
    ),

    'error' => array(
        'create' => 'Käyttäjä luonnissa tapahtui virhe. Yritä uudelleen.',
        'update' => 'Käyttäjän päivityksessä tapahtui virhe. Yritä uudelleen.',
        'delete' => 'Käyttäjän poistamisessa tapahtui virhe. Yritä uudelleen.',
        'unsuspend' => 'Käyttäjän jäädytyksen poistossa tapahtui virhe. Yritä uudelleen.',
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
        'success' => 'Tiedosto poistettiin onnistuneesti.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'Tiedostot lähetettiin onnistuneesti.',
        'nofiles' => 'Et valinnut yhtään tiedostoa lähetettäväksi',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);
