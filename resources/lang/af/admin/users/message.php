<?php

return array(

    'accepted'                  => 'U het hierdie bate suksesvol aanvaar.',
    'declined'                  => 'Jy het hierdie bate suksesvol geweier.',
    'bulk_manager_warn'	        => 'Jou gebruikers is suksesvol opgedateer, maar jou bestuurderinskrywing is nie gestoor nie, want die bestuurder wat jy gekies het, was ook in die gebruikerslys om geredigeer te word, en gebruikers mag nie hul eie bestuurder wees nie. Kies asseblief u gebruikers weer, behalwe die bestuurder.',
    'user_exists'               => 'Gebruiker bestaan ​​reeds!',
    'user_not_found'            => 'Gebruiker [: id] bestaan ​​nie.',
    'user_login_required'       => 'Die aanmeldingsveld is nodig',
    'user_password_required'    => 'Die wagwoord is nodig.',
    'insufficient_permissions'  => 'Onvoldoende Toestemmings.',
    'user_deleted_warning'      => 'Hierdie gebruiker is verwyder. Jy sal hierdie gebruiker moet herstel om hulle te wysig of nuwe bates toe te ken.',
    'ldap_not_configured'        => 'LDAP-integrasie is nie vir hierdie installasie gekonfigureer nie.',


    'success' => array(
        'create'    => 'Gebruiker is suksesvol geskep.',
        'update'    => 'Gebruiker is suksesvol opgedateer.',
        'update_bulk'    => 'Gebruikers is suksesvol opgedateer!',
        'delete'    => 'Gebruiker is suksesvol verwyder.',
        'ban'       => 'Gebruiker is suksesvol verban.',
        'unban'     => 'Gebruiker is suksesvol geblokkeer.',
        'suspend'   => 'Gebruiker is suksesvol opgeskort.',
        'unsuspend' => 'Gebruiker is suksesvol ingetrek.',
        'restored'  => 'Gebruiker is suksesvol herstel.',
        'import'    => 'Gebruikers suksesvol ingevoer.',
    ),

    'error' => array(
        'create' => 'Kon nie die gebruiker skep nie. Probeer asseblief weer.',
        'update' => 'Kon nie die gebruiker opdateer nie. Probeer asseblief weer.',
        'delete' => 'Daar was \'n probleem met die verwydering van die gebruiker. Probeer asseblief weer.',
        'delete_has_assets' => 'Hierdie gebruiker het items toegeken en kon nie uitgevee word nie.',
        'unsuspend' => 'Daar was \'n probleem wat die gebruiker onttrek het. Probeer asseblief weer.',
        'import'    => 'Kon nie gebruikers invoer nie. Probeer asseblief weer.',
        'asset_already_accepted' => 'Hierdie bate is reeds aanvaar.',
        'accept_or_decline' => 'U moet hierdie bate aanvaar of afkeur.',
        'incorrect_user_accepted' => 'Die bate wat u probeer aanvaar het, is nie na u gekontroleer nie.',
        'ldap_could_not_connect' => 'Kon nie aan die LDAP-bediener koppel nie. Gaan asseblief die LDAP-bediener opstelling in die LDAP-konfigurasie lêer. <br>Error van LDAP-bediener:',
        'ldap_could_not_bind' => 'Kon nie aan die LDAP-bediener bind nie. Gaan asseblief die LDAP-bediener opstelling in die LDAP-konfigurasie lêer. <br>Error van LDAP-bediener:',
        'ldap_could_not_search' => 'Kon nie die LDAP-bediener soek nie. Gaan asseblief die LDAP-bediener opstelling in die LDAP-konfigurasie lêer. <br>Error van LDAP-bediener:',
        'ldap_could_not_get_entries' => 'Kon nie inskrywings van die LDAP-bediener kry nie. Gaan asseblief die LDAP-bediener opstelling in die LDAP-konfigurasie lêer. <br>Error van LDAP-bediener:',
        'password_ldap' => 'Die wagwoord vir hierdie rekening word bestuur deur LDAP / Active Directory. Kontak asseblief u IT-afdeling om u wagwoord te verander.',
    ),

    'deletefile' => array(
        'error'   => 'Lêer nie verwyder nie. Probeer asseblief weer.',
        'success' => 'Lêer suksesvol uitgevee.',
    ),

    'upload' => array(
        'error'   => 'Lêer (s) nie opgelaai nie. Probeer asseblief weer.',
        'success' => 'Lêer (s) suksesvol opgelaai.',
        'nofiles' => 'Jy het nie enige lêers vir oplaai gekies nie',
        'invalidfiles' => 'Een of meer van jou lêers is te groot of is \'n filetipe wat nie toegelaat word nie. Toegelate filetipes is png, gif, jpg, doc, docx, pdf en txt.',
    ),

);
