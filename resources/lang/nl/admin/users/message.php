<?php

return array(

    'accepted'                  => 'Je hebt met succes dit product geaccepteerd.',
    'declined'                  => 'Je hebt met succes dit product geweigerd.',
    'bulk_manager_warn'	        => 'Uw gebruikers zijn succesvol bijgewerkt, de gekozen manager kon echter niet toegepast worden omdat deze persoon ook in de lijst staat, gebruikers mogen niet hun eigen manager zijn. Probeer het nogmaals en selecteer de gebruikers zonder de manager.',
    'user_exists'               => 'Gebruiker bestaat reeds!',
    'user_not_found'            => 'Gebruiker [:id] bestaat niet.',
    'user_login_required'       => 'Het veld gebruikersnaam is verplicht.',
    'user_password_required'    => 'Het veld wachtwoord is verplicht.',
    'insufficient_permissions'  => 'Onvoldoende rechten.',
    'user_deleted_warning'      => 'Deze gebruiker werd verwijderd. Om deze gebruiker te bewerken of toe te wijzen aan materiaal, zal deze opnieuw geactiveerd moeten worden.',
    'ldap_not_configured'        => 'LDAP integratie is niet geconfigureerd voor deze installatie.',


    'success' => array(
        'create'    => 'Gebruiker succesvol aangemaakt.',
        'update'    => 'Gebruiker succesvol bijgewerkt.',
        'update_bulk'    => 'Gebruikers zijn succesvol bijgewerkt!',
        'delete'    => 'Gebruiker succesvol verwijderd.',
        'ban'       => 'Gebruiker succesvol verbannen.',
        'unban'     => 'Gebruiker succesvol opnieuw toegang verleend.',
        'suspend'   => 'Gebruiker werd succesvol uitgeschakeld.',
        'unsuspend' => 'Gebruiker werd succesvol ingeschakeld.',
        'restored'  => 'Gebruiker werd succesvol opnieuw geactiveerd.',
        'import'    => 'Gebruikers met succes geïmporteerd.',
    ),

    'error' => array(
        'create' => 'Er was een probleem tijdens het aanmaken van de gebruiker. Probeer opnieuw, aub.',
        'update' => 'Er was een probleem tijdens het bijwerken van de gebruiker. Probeer opnieuw, aub.',
        'delete' => 'Er was een probleem tijdens het verwijderen van de gebruiker. Probeer opnieuw, aub.',
        'delete_has_assets' => 'Deze gebruiker heeft toegewezen items en kon niet worden verwijderd.',
        'unsuspend' => 'Er was een probleem tijdens het opnieuw inschakelen van de gebruiker. Probeer opnieuw, aub.',
        'import'    => 'Er was een probleem met het importeren van de gebruikers. Probeer het opnieuw.',
        'asset_already_accepted' => 'Dit product is al geaccepteerd.',
        'accept_or_decline' => 'Je moet dit product accepteren of weigeren.',
        'incorrect_user_accepted' => 'Het product wat je probeerde te accepteren is niet uitgecheckt aan jou.',
        'ldap_could_not_connect' => 'Kan niet verbinden met de LDAP server. Controleer je LDAP server configuratie in de LDAP configuratie bestand. <br>Fout van LDAP server:',
        'ldap_could_not_bind' => 'Kan niet verbinden met de LDAP server. Controleer je LDAP server configuratie in de LDAP configuratie bestand. <br>Fout van LDAP server: ',
        'ldap_could_not_search' => 'Kan niet zoeken in de LDAP server. Controleer je LDAP server configuratie in de LDAP configuratie bestand. <br>Fout van LDAP server:',
        'ldap_could_not_get_entries' => 'Kan geen gegeven van de LDAP server krijgen. Controleer je LDAP server configuratie in de LDAP configuratie bestand. <br>Fout van LDAP server:',
        'password_ldap' => 'Het wachtwoord voor deze account wordt beheerd door LDAP/Active Directory. Neem contact op met uw IT-afdeling om uw wachtwoord te wijzigen. ',
    ),

    'deletefile' => array(
        'error'   => 'Bestand is niet verwijderd. Probeer het opnieuw.',
        'success' => 'Bestand met succes verwijderd.',
    ),

    'upload' => array(
        'error'   => 'Bestand(en) zijn niet geüpload. Probeer het opnieuw.',
        'success' => 'Bestand(en) zijn met succes geüpload.',
        'nofiles' => 'Je hebt geen bestanden geselecteerd voor de upload',
        'invalidfiles' => 'Een of meer van uw bestanden is te groot of is een bestandstype dat niet is toegestaan. Toegestaande bestandstypen png, gif, jpg, doc, docx, pdf en txt.',
    ),

);
