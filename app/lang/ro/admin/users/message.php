<?php

return array(

    'accepted'                  => 'You have successfully accepted this asset.',
    'declined'                  => 'You have successfully declined this asset.',
    'user_exists'               => 'Utilizatorul exista deja!',
    'user_not_found'            => 'Utilizatorul [:id] nu exista.',
    'user_login_required'       => 'Campul de login este necesar',
    'user_password_required'    => 'Este necesara parola.',
    'insufficient_permissions'  => 'Nu aveti permisiuni suficiente.',
    'user_deleted_warning'      => 'Acest utilizator a fost sters. Trebuie sa restaurati utilizator ca sa-l editati sau sa-i desemnati active noi.',
    'ldap_not_configured'        => 'LDAP integration has not been configured for this installation.',


    'success' => array(
        'create'    => 'Utilizatorul a fost creat.',
        'update'    => 'Utilizatorul a fost actualizat.',
        'delete'    => 'Utilizatorul a fost sters.',
        'ban'       => 'Utilizatorul a fost banat.',
        'unban'     => 'Utilizatorul a fost debanat.',
        'suspend'   => 'Utilizatorul a fost suspendat.',
        'unsuspend' => 'Utilizatorul a fost activat.',
        'restored'  => 'Utilizatorul a fost restaurat.',
        'import'    => 'Users imported successfully.',
    ),

    'error' => array(
        'create' => 'A aparut o problema la crearea utilizatorului. Incercati iar.',
        'update' => 'A aparut o problema la actualizarea utilizatorului. Incercati iar.',
        'delete' => 'A aparut o problema la stergerea utilizatorului. Incercati iar.',
        'unsuspend' => 'A aparut o problema la reactivarea utilizatorului. Incercati iar.',
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
