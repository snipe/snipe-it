<?php

return array(

    'accepted'                  => 'Du har akseptert eiendelen.',
    'declined'                  => 'Du har avvist eiendelen.',
    'bulk_manager_warn'	        => 'Brukerne er oppdatert, men lederen ble ikke lagret fordi lederen du valgte også i brukerlisten for redigering og brukere kan ikke være sin egen leder. Velg brukerne igjen, unntatt lederen.',
    'user_exists'               => 'Bruker finnes allerede!',
    'user_not_found'            => 'User does not exist.',
    'user_login_required'       => 'Login-feltet er påkrevd',
    'user_password_required'    => 'Passord er påkrevd.',
    'insufficient_permissions'  => 'Utilstrekkelige rettigheter.',
    'user_deleted_warning'      => 'Denne brukeren er slettet. Du vil må gjenopprette denne brukeren for å redigere, eller tildele nye eiendeler.',
    'ldap_not_configured'        => 'LDAP integrasjonen er ikke konfigurert i denne installasjonen.',
    'password_resets_sent'      => 'De valgte brukerne som er aktivert og har en gyldig e-postadresse har blitt sendt en tilbakestillingslenke.',
    'password_reset_sent'       => 'En lenke for tilbakestilling av passord har blitt sendt til :email!',
    'user_has_no_email'         => 'This user does not have an email address in their profile.',
    'user_has_no_assets_assigned'   => 'This user does not have any assets assigned',


    'success' => array(
        'create'    => 'Opprettelse av bruker vellykket.',
        'update'    => 'Oppdatering av bruker vellykket.',
        'update_bulk'    => 'Oppdatering av brukere vellykket!',
        'delete'    => 'Sletting av bruker vellykket.',
        'ban'       => 'Vellykket forbud av bruker.',
        'unban'     => 'Forbud av bruker ble opphevet.',
        'suspend'   => 'Vellykket deaktivering av bruker.',
        'unsuspend' => 'Vellykket aktivering av bruker.',
        'restored'  => 'Vellykket gjenopprettelse av bruker.',
        'import'    => 'Vellykket import av brukere.',
    ),

    'error' => array(
        'create' => 'Det oppstod et problem under opprettelse av bruker. Prøv igjen.',
        'update' => 'Det oppstod et problem under oppdatering av bruker. Prøv igjen.',
        'delete' => 'Det oppstod et problem under sletting av bruker. Prøv igjen.',
        'delete_has_assets' => 'Denne brukeren har utstyr tildelt og kan ikke slettes.',
        'unsuspend' => 'Det oppstod et problem under aktivering av bruker. Prøv igjen.',
        'import'    => 'Det oppstod et problem under import av brukere. Prøv igjen.',
        'asset_already_accepted' => 'Denne eiendelen er allerede akseptert.',
        'accept_or_decline' => 'Du må enten akseptere eller avvise denne eiendelen.',
        'incorrect_user_accepted' => 'Eiendelen du prøvde å akseptere ble ikke sjekket ut til deg.',
        'ldap_could_not_connect' => 'Kunne ikke kople til LDAP-serveren. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server:',
        'ldap_could_not_bind' => 'Kunne ikke opprette tilkopling til LDAP-server. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server: ',
        'ldap_could_not_search' => 'Kunne ikke utføre søk på LDAP-serveren. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server:',
        'ldap_could_not_get_entries' => 'Fikk ingen oppføringer fra LDAP-serveren. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server:',
        'password_ldap' => 'Passordet for denne kontoen administreres av LDAP/Active Directory. Kontakt IT-avdelingen for å endre passordet. ',
    ),

    'deletefile' => array(
        'error'   => 'Fil ble ikke slettet. Prøv igjen.',
        'success' => 'Fil ble slettet.',
    ),

    'upload' => array(
        'error'   => 'Fil(er) ble ikke lastet opp. Prøv igjen.',
        'success' => 'Vellykket opplasting av fil(er).',
        'nofiles' => 'Du valgte ingen filer for opplasting',
        'invalidfiles' => 'En eller flere av filene dine er for store eller av en filtype som ikke er tillatt. Tillatte filtyper er png, gif, jpg, doc, docx, pdf og txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'This user has no email set.',
        'success' => 'The user has been notified about their current inventory.'
    )
);