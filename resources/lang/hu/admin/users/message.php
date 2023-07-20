<?php

return array(

    'accepted'                  => 'Ön sikeresen elfogadta ezt az eszközt.',
    'declined'                  => 'Az eszközt sikeresen csökkentetted.',
    'bulk_manager_warn'	        => 'A felhasználók sikeresen frissültek, azonban a kezelői bejegyzést nem mentette el, mert a kiválasztott kezelő a szerkesztőben is szerepel a felhasználók listájában, és a felhasználók nem lehetnek saját kezelőik. Kérjük, ismét válassza ki a felhasználókat, kivéve a kezelőt.',
    'user_exists'               => 'Felhasználó már létezik!',
    'user_not_found'            => 'Felhasználó nem létezik.',
    'user_login_required'       => 'A bejelentkezési mező kötelező',
    'user_password_required'    => 'A jelszó szükséges.',
    'insufficient_permissions'  => 'Nem megfelelő engedélyek.',
    'user_deleted_warning'      => 'Ezt a felhasználót törölték. Ezt a felhasználót vissza kell állítania, hogy szerkeszteni tudja őket, vagy hozzárendelhessen új eszközökhöz.',
    'ldap_not_configured'        => 'Az LDAP integráció nem lett konfigurálva ehhez a telepítéshez.',
    'password_resets_sent'      => 'A kiválasztott felhasználók számára, akik aktívak és van nekik érvényes email cím, elküldésre került egy jelszó visszaállítási link.',
    'password_reset_sent'       => 'A jelszó visszaállítási link elküldésre került a :email címre!',
    'user_has_no_email'         => 'Ez a felhasználó nem rendelkezik e-mail címmel a profiljában.',
    'user_has_no_assets_assigned'   => 'Ehhez a felhasználóhoz nincsenek eszközök rendelve',


    'success' => array(
        'create'    => 'A felhasználó sikeresen létrejött.',
        'update'    => 'A felhasználó módosítása sikeresen megtörtént.',
        'update_bulk'    => 'A felhasználók sikeresen frissültek!',
        'delete'    => 'A felhasználó törlése sikeresen megtörtént.',
        'ban'       => 'A felhasználó sikeresen tiltott.',
        'unban'     => 'A felhasználó sikeresen meg volt semmisítve.',
        'suspend'   => 'A felhasználó sikeresen felfüggesztésre került.',
        'unsuspend' => 'A felhasználó sikeresen felfüggesztésre került.',
        'restored'  => 'A felhasználó sikeresen visszaállt.',
        'import'    => 'A felhasználók sikeresen importáltak.',
    ),

    'error' => array(
        'create' => 'Hiba történt a felhasználó létrehozásában. Kérlek próbáld újra.',
        'update' => 'Hiba történt a felhasználó frissítésében. Kérlek próbáld újra.',
        'delete' => 'A felhasználó törölte a problémát. Kérlek próbáld újra.',
        'delete_has_assets' => 'Ez a felhasználó rendelkezik elemekkel, amelyeket nem lehet törölni.',
        'unsuspend' => 'A felhasználó felfüggesztette a problémát. Kérlek próbáld újra.',
        'import'    => 'Hiba történt a felhasználók importálása során. Kérlek próbáld újra.',
        'asset_already_accepted' => 'Ezt az eszközt már elfogadták.',
        'accept_or_decline' => 'El kell fogadnia vagy el kell utasítania ezt az eszközt.',
        'incorrect_user_accepted' => 'Az általad megpróbált eszköz nem lett kiegyenlítve.',
        'ldap_could_not_connect' => 'Nem sikerült csatlakozni az LDAP kiszolgálóhoz. Ellenőrizze az LDAP kiszolgáló konfigurációját az LDAP konfigurációs fájlban. <br>Az LDAP kiszolgáló hibája:',
        'ldap_could_not_bind' => 'Nem sikerült kötni az LDAP kiszolgálóhoz. Ellenőrizze az LDAP kiszolgáló konfigurációját az LDAP konfigurációs fájlban. <br>Az LDAP kiszolgáló hibája:',
        'ldap_could_not_search' => 'Nem sikerült keresni az LDAP kiszolgálót. Ellenőrizze az LDAP kiszolgáló konfigurációját az LDAP konfigurációs fájlban. <br>Az LDAP kiszolgáló hibája:',
        'ldap_could_not_get_entries' => 'Nem sikerült bejegyzéseket szerezni az LDAP kiszolgálóról. Ellenőrizze az LDAP kiszolgáló konfigurációját az LDAP konfigurációs fájlban. <br>Az LDAP kiszolgáló hibája:',
        'password_ldap' => 'A fiókhoz tartozó jelszót az LDAP / Active Directory kezeli. Kérjük, lépjen kapcsolatba informatikai részlegével a jelszó megváltoztatásához.',
    ),

    'deletefile' => array(
        'error'   => 'A fájl nem törölve. Kérlek próbáld újra.',
        'success' => 'A fájl sikeresen törölve.',
    ),

    'upload' => array(
        'error'   => 'Fel nem töltött fájl (ok). Kérlek próbáld újra.',
        'success' => 'Fájl (ok) sikeresen feltöltve.',
        'nofiles' => 'Nem választottál fel fájlokat a feltöltéshez',
        'invalidfiles' => 'Egy vagy több fájl túl nagy vagy egy filetype, amely nem megengedett. Az engedélyezett fájltípusok png, gif, jpg, doc, docx, pdf és txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'A felhasználóhoz nincs email cím beállítva.',
        'success' => 'A felhasználót értesítettük a hozzárendelt eszközökről.'
    )
);