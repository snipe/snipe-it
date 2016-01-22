<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Użytkownik już istnieje!',
    'user_not_found'            => 'User [:id] nie istnieje.',
    'user_login_required'       => 'Pole login jest wymagane',
    'user_password_required'    => 'Pole hasło jest wymagane.',
    'insufficient_permissions'  => 'Brak uprawnień.',
    'user_deleted_warning'      => 'This user has been deleted. You will have to restore this user to edit them or assign them new assets.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'Użytkownik utworzony pomyślnie.',
        'update'    => 'Użytkownik zaktualizowany pomyślnie.',
        'delete'    => 'Użytkownik został usunięty pomyślnie.',
        'ban'       => 'Użytkownik został zablokowany.',
        'unban'     => 'Użytkownik został odblokowany.',
        'suspend'   => 'Konto użytkownika zostało wyłączone.',
        'unsuspend' => 'Konto użytkownika zostało włączone.',
        'restored'  => 'Użytkownik został przywrócony pomyślnie.',
        'import'    => 'Import użytkowników zakończony sukcesem.',
    ),

    'error' => array(
        'create' => 'Podczas tworzenia użytkownika wystąpił problem. Spróbuj ponownie.',
        'update' => 'Podczas aktualizacji użytkownika wystąpił problem. Spróbuj ponownie.',
        'delete' => 'Wystąpił błąd podczas usuwania użytkownika. Spróbuj ponownie.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'import'    => 'Podczas importowania użytkowników wystąpił błąd. Spróbuj ponownie.',
        'asset_already_accepted' => 'This asset has already been accepted.',
        'accept_or_decline' => 'You must either accept or decline this asset.',
        'incorrect_user_accepted' => 'The asset you have attempted to accept was not checked out to you.',
        'ldap_could_not_connect' => 'Could not connect to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_bind' => 'Could not bind to the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server: ',
        'ldap_could_not_search' => 'Could not search the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
        'ldap_could_not_get_entries' => 'Could not get entries from the LDAP server. Please check your LDAP server configuration in the LDAP config file. <br>Error from LDAP Server:',
    ),

    'deletefile' => array(
        'error'   => 'Pliki nie zostały usunięte. Spróbuj ponownie.',
        'success' => 'Pliki zostały usunięte.',
    ),

    'upload' => array(
        'error'   => 'Plik(i) nie zostały wysłane. Spróbuj ponownie.',
        'success' => 'Plik(i) zostały wysłane poprawnie.',
        'nofiles' => 'Nie wybrałeś żadnych plików do wysłania',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);
