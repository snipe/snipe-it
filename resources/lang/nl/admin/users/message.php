<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Gebruiker bestaat reeds!',
    'user_not_found'            => 'Gebruiker [:id] bestaat niet.',
    'user_login_required'       => 'Het veld gebruikersnaam is verplicht.',
    'user_password_required'    => 'Het veld wachtwoord is verplicht.',
    'insufficient_permissions'  => 'Onvoldoende rechten.',
    'user_deleted_warning'      => 'Deze gebruiker werd verwijderd. Om deze gebruiker te bewerken of toe te wijzen aan materiaal, zal deze opnieuw geactiveerd moeten worden.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'Gebruiker succesvol aangemaakt.',
        'update'    => 'Gebruiker succesvol bijgewerkt.',
        'delete'    => 'Gebruiker succesvol verwijderd.',
        'ban'       => 'Gebruiker succesvol verbannen.',
        'unban'     => 'Gebruiker succesvol opnieuw toegang verleend.',
        'suspend'   => 'Gebruiker werd succesvol uitgeschakeld.',
        'unsuspend' => 'Gebruiker werd succesvol ingeschakeld.',
        'restored'  => 'Gebruiker werd succesvol opnieuw geactiveerd.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'Er was een probleem tijdens het aanmaken van de gebruiker. Probeer opnieuw, aub.',
        'update' => 'Er was een probleem tijdens het bijwerken van de gebruiker. Probeer opnieuw, aub.',
        'delete' => 'Er was een probleem tijdens het verwijderen van de gebruiker. Probeer opnieuw, aub.',
        'unsuspend' => 'Er was een probleem tijdens het opnieuw inschakelen van de gebruiker. Probeer opnieuw, aub.',
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
