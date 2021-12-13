<?php

return array(

    'accepted'                  => 'To sredstev ste uspešno sprejeli.',
    'declined'                  => 'To sredstev ste uspešno zavrnili.',
    'bulk_manager_warn'	        => 'Vaši uporabniki so bili uspešno posodobljeni, vendar vnos v upravitelju ni bil shranjen, ker je bil izbran upravitelj tudi na seznamu uporabnikov, ki ga je treba urediti, uporabniki pa morda niso njihovi lastniki. Prosimo, izberite svoje uporabnike, razen upravitelja.',
    'user_exists'               => 'Uporabnik že obstaja!',
    'user_not_found'            => 'Uporabnik [: id] ne obstaja.',
    'user_login_required'       => 'Polje za prijavo je obvezno',
    'user_password_required'    => 'Geslo je obvezno.',
    'insufficient_permissions'  => 'Nezadostna dovoljenja.',
    'user_deleted_warning'      => 'Ta uporabnik je bil izbrisan. Tega uporabnika boste morali obnoviti, da ga uredite ali dodelite nova sredstva.',
    'ldap_not_configured'        => 'Integracija LDAP za to namestitev ni bila konfigurirana.',
    'password_resets_sent'      => 'Izbranim aktiviranim uporabnikom z veljavnim e-poštnim računom je bila poslana povezava za ponastavitev gesla.',
    'password_reset_sent'       => 'Povezava za ponastavitev gesla je bila poslana na :email!',


    'success' => array(
        'create'    => 'Uporabnik je bil uspešno ustvarjen.',
        'update'    => 'Uporabnik je bil uspešno posodobljen.',
        'update_bulk'    => 'Uporabniki so bili uspešno posodobljeni!',
        'delete'    => 'Uporabnik je bil uspešno izbrisan.',
        'ban'       => 'Uporabnik je bil prepovedan.',
        'unban'     => 'Uporabnik je bil uspešno od-prepovedan.',
        'suspend'   => 'Uporabnik je bil uspešno suspendiran.',
        'unsuspend' => 'Uporabnik je bil uspešno od-suspendiran.',
        'restored'  => 'Uporabnik je bil uspešno obnovljen.',
        'import'    => 'Uporabniki so bili uvoženi uspešno.',
    ),

    'error' => array(
        'create' => 'Pri ustvarjanju uporabnika je prišlo do težave. Prosim poskusite ponovno.',
        'update' => 'Prišlo je do težave pri posodabljanju uporabnika. Prosim poskusite ponovno.',
        'delete' => 'Pri brisanju uporabnika je prišlo do težave. Prosim poskusite ponovno.',
        'delete_has_assets' => 'Ta uporabnik ima dodeljene elemente in ga ni mogoče izbrisati.',
        'unsuspend' => 'Prišlo je do težave pri od-suspendiranju uporabnika. Prosim poskusite ponovno.',
        'import'    => 'Pri uvozu uporabnikov je prišlo do težave. Prosim poskusite ponovno.',
        'asset_already_accepted' => 'To sredstvo je bilo že sprejeto.',
        'accept_or_decline' => 'To sredstev morate sprejeti ali zavrniti.',
        'incorrect_user_accepted' => 'Sredstev, ki ste ga poskušali sprejeti, ni bilo izdano za vas.',
        'ldap_could_not_connect' => 'Povezave s strežnikom LDAP ni bilo mogoče vzpostaviti. Preverite konfiguracijo strežnika LDAP v konfiguracijski datoteki LDAP. <br>Napaka strežnika LDAP:',
        'ldap_could_not_bind' => 'Povezave s strežnikom LDAP ni bilo mogoče vzpostaviti. Preverite konfiguracijo strežnika LDAP v konfiguracijski datoteki LDAP. <br>Napaka strežnika LDAP: ',
        'ldap_could_not_search' => 'Strežnika LDAP ni bilo mogoče najti. Preverite konfiguracijo strežnika LDAP v konfiguracijski datoteki LDAP. <br>Napaka strežnika LDAP:',
        'ldap_could_not_get_entries' => 'Vnose iz strežnika LDAP ni bilo mogoče pridobiti. Preverite konfiguracijo strežnika LDAP v konfiguracijski datoteki LDAP. <br>Napaka strežnika LDAP:',
        'password_ldap' => 'Geslo za ta račun upravlja LDAP / Active Directory. Za spremembo gesla se obrnite na oddelek IT. ',
    ),

    'deletefile' => array(
        'error'   => 'Datoteka ni izbrisana. Prosim poskusite ponovno.',
        'success' => 'Datoteka je uspešno izbrisana.',
    ),

    'upload' => array(
        'error'   => 'Datoteka(e) niso naložene. Prosim poskusite ponovno.',
        'success' => 'Datoteka(e) so bile uspešno naložene.',
        'nofiles' => 'Niste izbrali nobenih datotek za nalaganje',
        'invalidfiles' => 'Ena ali več vaših datotek je prevelika ali pa je tip datoteke, ki ni dovoljen. Dovoljeni tipi datotek so png, gif, jpg, doc, docx, pdf in txt.',
    ),

);
