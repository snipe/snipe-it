<?php

return array(

    'accepted'                  => 'Du har akseptert eiendelen.',
    'declined'                  => 'Du har avvist eiendelen.',
    'bulk_manager_warn'	        => 'Your users have been successfully updated, however your manager entry was not saved because the manager you selected was also in the user list to be edited, and users may not be their own manager. Please select your users again, excluding the manager.',
    'user_exists'               => 'Bruker finnes allerede!',
    'user_not_found'            => 'Bruker [:id] finnes ikke.',
    'user_login_required'       => 'Login-feltet er påkrevd',
    'user_password_required'    => 'Passord er påkrevd.',
    'insufficient_permissions'  => 'Utilstrekkelige rettigheter.',
    'user_deleted_warning'      => 'Denne brukeren er slettet. Du vil må gjenopprette denne brukeren for å redigere, eller tildele nye eiendeler.',
    'ldap_not_configured'        => 'LDAP integrasjonen er ikke konfigurert i denne installasjonen.',


    'success' => array(
        'create'    => 'Opprettelse av bruker vellykket.',
        'update'    => 'Oppdatering av bruker vellykket.',
        'update_bulk'    => 'Users were successfully updated!',
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
        'delete_has_assets' => 'This user has items assigned and could not be deleted.',
        'unsuspend' => 'Det oppstod et problem under aktivering av bruker. Prøv igjen.',
        'import'    => 'Det oppstod et problem under import av brukere. Prøv igjen.',
        'asset_already_accepted' => 'Denne eiendelen er allerede akseptert.',
        'accept_or_decline' => 'Du må enten akseptere eller avvise denne eiendelen.',
        'incorrect_user_accepted' => 'Eiendelen du prøvde å akseptere ble ikke sjekket ut til deg.',
        'ldap_could_not_connect' => 'Kunne ikke kople til LDAP-serveren. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server:',
        'ldap_could_not_bind' => 'Kunne ikke opprette tilkopling til LDAP-server. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server: ',
        'ldap_could_not_search' => 'Kunne ikke utføre søk på LDAP-serveren. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server:',
        'ldap_could_not_get_entries' => 'Fikk ingen oppføringer fra LDAP-serveren. Sjekk LDAP-innstillingene i konfigurasjonsfilen. <br>Feil fra LDAP-server:',
        'password_ldap' => 'The password for this account is managed by LDAP/Active Directory. Please contact your IT department to change your password. ',
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

);
