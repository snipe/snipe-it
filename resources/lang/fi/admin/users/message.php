<?php

return array(

    'accepted'                  => 'Olet hyväksynyt tämän aineiston.',
    'declined'                  => 'Olet onnistunut hylkäsi tämän aineiston.',
    'bulk_manager_warn'	        => 'Käyttäjiäsi on onnistuneesti päivitetty, mutta pääkäyttäjän merkintääsi ei tallennettu, koska valitsemasi hallinnoijan oli myös muokattava käyttäjäluettelossa, eivätkä käyttäjät ole omaa päällikköään. Valitse käyttäjät uudelleen, poislukien johtajan.',
    'user_exists'               => 'Käyttäjää on jo luotu!',
    'user_not_found'            => 'Käyttäjää [:id] ei löydy.',
    'user_login_required'       => 'Käyttäjätunnus vaaditaan',
    'user_password_required'    => 'Salasana vaaditaan.',
    'insufficient_permissions'  => 'Riittämättömät Oikeudet.',
    'user_deleted_warning'      => 'Käyttäjä on jo poistettu. Mikäli haluat muokata tai luovuttaa laitteita hänelle sinun tulee palauttaa käyttäjä.',
    'ldap_not_configured'        => 'LDAP-integraatiota ei ole määritetty tässä asennuksessa.',


    'success' => array(
        'create'    => 'Käyttäjä luotiin onnistuneesti.',
        'update'    => 'Käyttäjä päivitettiin onnistuneesti.',
        'update_bulk'    => 'Käyttäjiä päivitettiin onnistuneesti!',
        'delete'    => 'Käyttäjä poistettiin onnistuneesti.',
        'ban'       => 'Käyttäjä estettiin onnistuneesti.',
        'unban'     => 'Käyttäjän esto poistettiin onnistuneesti.',
        'suspend'   => 'Käyttäjä jäädytettiin onnistuneesti.',
        'unsuspend' => 'Käyttäjän jäädytys poistettiin onnistuneesti.',
        'restored'  => 'Käyttäjä palautettiin onnistuneesti.',
        'import'    => 'Käyttäjät tuotiin onnistuneesti.',
    ),

    'error' => array(
        'create' => 'Käyttäjä luonnissa tapahtui virhe. Yritä uudelleen.',
        'update' => 'Käyttäjän päivityksessä tapahtui virhe. Yritä uudelleen.',
        'delete' => 'Käyttäjän poistamisessa tapahtui virhe. Yritä uudelleen.',
        'delete_has_assets' => 'Tällä käyttäjällä on kohteita, joita ei voitu poistaa.',
        'unsuspend' => 'Käyttäjän jäädytyksen poistossa tapahtui virhe. Yritä uudelleen.',
        'import'    => 'Käyttäjä tuonut käyttäjiä. Yritä uudelleen.',
        'asset_already_accepted' => 'Tämä omaisuus on jo hyväksytty.',
        'accept_or_decline' => 'Sinun on joko hyväksyttävä tai hylättävä tämä omaisuus.',
        'incorrect_user_accepted' => 'Omaasi, jonka olet yrittänyt hyväksyä, ei ole tarkistettu sinulle.',
        'ldap_could_not_connect' => 'LDAP-palvelinta ei voitu muodostaa. Tarkista LDAP-palvelimen määritys LDAP-määritystiedostossa. <br>Häiriö LDAP-palvelimelta:',
        'ldap_could_not_bind' => 'LDAP-palvelinta ei voitu sitoa. Tarkista LDAP-palvelimen määritys LDAP-määritystiedostossa. <br>Häiriö LDAP-palvelimelta:',
        'ldap_could_not_search' => 'LDAP-palvelinta ei voitu hakea. Tarkista LDAP-palvelimen määritys LDAP-määritystiedostossa. <br>Häiriö LDAP-palvelimelta:',
        'ldap_could_not_get_entries' => 'LDAP-palvelimelta ei saatu merkintöjä. Tarkista LDAP-palvelimen määritys LDAP-määritystiedostossa. <br>Häiriö LDAP-palvelimelta:',
        'password_ldap' => 'Tätä salasanaa hallinnoi LDAP / Active Directory. Vaihda salasanasi IT-osastolla.',
    ),

    'deletefile' => array(
        'error'   => 'Tiedostoa ei ole poistettu. Yritä uudelleen.',
        'success' => 'Tiedosto poistettiin onnistuneesti.',
    ),

    'upload' => array(
        'error'   => 'Tiedostoja ei ole ladattu. Yritä uudelleen.',
        'success' => 'Tiedostot lähetettiin onnistuneesti.',
        'nofiles' => 'Et valinnut yhtään tiedostoa lähetettäväksi',
        'invalidfiles' => 'Yksi tai useampi tiedosto on liian suuri tai on filetype, jota ei sallita. Sallitut tiedostotyypit ovat png, gif, jpg, doc, docx, pdf ja txt.',
    ),

);
