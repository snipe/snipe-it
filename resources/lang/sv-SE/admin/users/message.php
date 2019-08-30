<?php

return array(

    'accepted'                  => 'Du har framgångsrikt godkänt den här tillgången.',
    'declined'                  => 'Du har framgångsrikt nekat den här tillgången.',
    'bulk_manager_warn'	        => 'Dina användare har blivit uppdaterade, men din administratörsinmatning sparades inte eftersom den chef du valde också var i användarlistan som ska redigeras, och användare kanske inte är deras egen chef. Vänligen välj dina användare igen, med undantag av chefen.',
    'user_exists'               => 'Användaren existerar redan!',
    'user_not_found'            => 'Användare [: id] existerar inte.',
    'user_login_required'       => 'Inloggningsfältet krävs',
    'user_password_required'    => 'Lösenordet krävs.',
    'insufficient_permissions'  => 'Otillräckliga tillstånd.',
    'user_deleted_warning'      => 'Den här användaren har raderats. Du måste återställa den här användaren för att redigera dem eller tilldela dem nya tillgångar.',
    'ldap_not_configured'        => 'LDAP-integrationen har inte konfigurerats för den här installationen.',


    'success' => array(
        'create'    => 'Användaren skapades med framgång.',
        'update'    => 'Användaren har uppdaterats.',
        'update_bulk'    => 'Användarna uppdaterades med framgång!',
        'delete'    => 'Användaren har tagits bort.',
        'ban'       => 'Användaren har blivit bannlyst.',
        'unban'     => 'Användaren var framgångsrikt obuten.',
        'suspend'   => 'Användaren avbröts.',
        'unsuspend' => 'Användaren blev framgångsrikt uppslagen.',
        'restored'  => 'Användaren lyckades återställas.',
        'import'    => 'Användare importerades framgångsrikt.',
    ),

    'error' => array(
        'create' => 'Det var ett problem att skapa användaren. Var god försök igen.',
        'update' => 'Det gick inte att uppdatera användaren. Var god försök igen.',
        'delete' => 'Det gick inte att ta bort användaren. Var god försök igen.',
        'delete_has_assets' => 'Den här användaren har objekt tilldelade och kunde inte raderas.',
        'unsuspend' => 'Det uppstod ett problem som avbröt användaren. Var god försök igen.',
        'import'    => 'Det gick inte att importera användare. Var god försök igen.',
        'asset_already_accepted' => 'Denna tillgång har redan godkänts.',
        'accept_or_decline' => 'Du måste antingen godkänna eller neka den här tillgången.',
        'incorrect_user_accepted' => 'Den tillgång du försökte acceptera har inte checkats ut till dig.',
        'ldap_could_not_connect' => 'Det gick inte att ansluta till LDAP-servern. Kontrollera din LDAP-serverkonfiguration i LDAP-konfigurationsfilen. <br>Fel från LDAP-servern:',
        'ldap_could_not_bind' => 'Kunde inte binda till LDAP-servern. Kontrollera din LDAP-serverkonfiguration i LDAP-konfigurationsfilen. <br>Fel från LDAP-servern:',
        'ldap_could_not_search' => 'Det gick inte att söka på LDAP-servern. Kontrollera din LDAP-serverkonfiguration i LDAP-konfigurationsfilen. <br>Fel från LDAP-servern:',
        'ldap_could_not_get_entries' => 'Det gick inte att få poster från LDAP-servern. Kontrollera din LDAP-serverkonfiguration i LDAP-konfigurationsfilen. <br>Fel från LDAP-servern:',
        'password_ldap' => 'Lösenordet för det här kontot hanteras av LDAP / Active Directory. Vänligen kontakta din IT-avdelning för att ändra ditt lösenord.',
    ),

    'deletefile' => array(
        'error'   => 'Filen har inte tagits bort. Var god försök igen.',
        'success' => 'Filen har tagits bort.',
    ),

    'upload' => array(
        'error'   => 'Fil (er) inte uppladdade. Var god försök igen.',
        'success' => 'Filer som har laddats upp.',
        'nofiles' => 'Du valde inte några filer för uppladdning',
        'invalidfiles' => 'En eller flera av dina filer är för stora eller är en filtyp som inte är tillåten. Tillåtna filtyper är png, gif, jpg, doc, docx, pdf och txt.',
    ),

);
