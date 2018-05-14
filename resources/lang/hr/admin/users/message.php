<?php

return array(

    'accepted'                  => 'Uspješno ste prihvatili ovaj materijal.',
    'declined'                  => 'Uspješno ste odbili ovaj materijal.',
    'bulk_manager_warn'	        => 'Vaši su korisnici uspješno ažurirani, ali vaš unos upravitelja nije spremljen jer je upravitelj koji ste odabrali također bio na popisu korisnika koji se uređuje, a korisnici možda nisu vlastiti upravitelj. Ponovno odaberite svoje korisnike, isključujući upravitelja.',
    'user_exists'               => 'Korisnik već postoji!',
    'user_not_found'            => 'Korisnik [: id] ne postoji.',
    'user_login_required'       => 'Potrebno je polje za prijavu',
    'user_password_required'    => 'Zaporka je potrebna.',
    'insufficient_permissions'  => 'Nedovoljna dozvola.',
    'user_deleted_warning'      => 'Ovaj je korisnik izbrisan. Morat ćete vratiti tog korisnika da biste ih uredili ili dodijelili novu imovinu.',
    'ldap_not_configured'        => 'LDAP integracija nije konfigurirana za ovu instalaciju.',


    'success' => array(
        'create'    => 'Korisnik je uspješno izrađen.',
        'update'    => 'Korisnik je uspješno ažuriran.',
        'update_bulk'    => 'Korisnici su uspješno ažurirani!',
        'delete'    => 'Korisnik je uspješno izbrisan.',
        'ban'       => 'Korisnik je uspješno zabranjen.',
        'unban'     => 'Korisnik je uspješno bio razotkriven.',
        'suspend'   => 'Korisnik je uspješno obustavljen.',
        'unsuspend' => 'Korisnik je uspješno suspendiran.',
        'restored'  => 'Korisnik je uspješno obnovljen.',
        'import'    => 'Korisnici su uspješno uvezeni.',
    ),

    'error' => array(
        'create' => 'Pojavio se problem pri stvaranju korisnika. Molim te pokušaj ponovno.',
        'update' => 'Došlo je do problema s ažuriranjem korisnika. Molim te pokušaj ponovno.',
        'delete' => 'Došlo je do problema s brisanjem korisnika. Molim te pokušaj ponovno.',
        'delete_has_assets' => 'Ovaj korisnik ima stavke dodijeljene i nije ih moguće izbrisati.',
        'unsuspend' => 'Došlo je do problema s obustavom korisnika. Molim te pokušaj ponovno.',
        'import'    => 'Došlo je do problema s uvozom korisnika. Molim te pokušaj ponovno.',
        'asset_already_accepted' => 'Ova je imovina već prihvaćena.',
        'accept_or_decline' => 'Morate prihvatiti ili odbiti ovaj materijal.',
        'incorrect_user_accepted' => 'Predmete koje ste pokušali prihvatiti nisu provjereni.',
        'ldap_could_not_connect' => 'Povezivanje s LDAP poslužiteljem nije uspjelo. Provjerite konfiguraciju LDAP poslužitelja u LDAP konfiguracijskoj datoteci. <br>Preku s LDAP poslužitelja:',
        'ldap_could_not_bind' => 'Nije moguće povezati se s LDAP poslužiteljem. Provjerite konfiguraciju LDAP poslužitelja u LDAP konfiguracijskoj datoteci. <br>Preku s LDAP poslužitelja:',
        'ldap_could_not_search' => 'Nije moguće pretražiti LDAP poslužitelj. Provjerite konfiguraciju LDAP poslužitelja u LDAP konfiguracijskoj datoteci. <br>Preku s LDAP poslužitelja:',
        'ldap_could_not_get_entries' => 'Nije bilo moguće dobiti unose s LDAP poslužitelja. Provjerite konfiguraciju LDAP poslužitelja u LDAP konfiguracijskoj datoteci. <br>Preku s LDAP poslužitelja:',
        'password_ldap' => 'Lozinku za ovaj račun upravlja LDAP / Active Directory. Obratite se IT odjelu za promjenu zaporke.',
    ),

    'deletefile' => array(
        'error'   => 'Datoteka nije izbrisana. Molim te pokušaj ponovno.',
        'success' => 'Datoteka je uspješno obrisana.',
    ),

    'upload' => array(
        'error'   => 'Datoteke nisu prenesene. Molim te pokušaj ponovno.',
        'success' => 'Datoteke su uspješno učitane.',
        'nofiles' => 'Niste odabrali nijednu datoteku za prijenos',
        'invalidfiles' => 'Jedna ili više datoteka je prevelika ili je vrsta datoteke koja nije dopuštena. Dopuštene vrste datoteka su png, gif, jpg, doc, docx, pdf i txt.',
    ),

);
