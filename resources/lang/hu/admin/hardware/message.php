<?php

return array(

    'undeployable' 		=> '<strong>Figyelem: </strong> Ez az eszköz pillanatnyilag  nem kiadható. Ha ez a helyzet változott, kérjük, frissítse az eszköz állapotát.',
    'does_not_exist' 	=> 'Eszköz nem létezik.',
    'does_not_exist_or_not_requestable' => 'Szép próbálkozás. Az eszköz nem létezik, vagy nem igényelhető.',
    'assoc_users'	 	=> 'Ez az eszköz jelenleg ki van jelölve egy felhasználónak, és nem törölhető. Kérjük, először ellenőrizze az eszközt, majd próbálja meg újra törölni.',

    'create' => array(
        'error'   		=> 'Az eszköz nem jött létre, próbálkozzon újra. :(',
        'success' 		=> 'Az eszköz sikeresen létrehozva. :)'
    ),

    'update' => array(
        'error'   			=> 'Az eszköz nem frissült, próbálkozzon újra',
        'success' 			=> 'Az eszköz sikeresen frissült.',
        'nothing_updated'	=>  'Nem választottak ki mezőket, így semmi sem frissült.',
    ),

    'restore' => array(
        'error'   		=> 'Az eszköz nem állt helyre, kérjük, próbálkozzon újra',
        'success' 		=> 'Az eszköz sikeresen visszaállítva.'
    ),

    'audit' => array(
        'error'   		=> 'Az eszközellenőrzés sikertelen volt. Kérlek próbáld újra.',
        'success' 		=> 'Az eszközellenőrzés sikeresen be van jelentkezve.'
    ),


    'deletefile' => array(
        'error'   => 'A fájl nem törölve. Kérlek próbáld újra.',
        'success' => 'A fájl sikeresen törölve.',
    ),

    'upload' => array(
        'error'   => 'Fel nem töltött fájl (ok). Kérlek próbáld újra.',
        'success' => 'Fájl (ok) sikeresen feltöltve.',
        'nofiles' => 'Nem választottál fel fájlokat a feltöltéshez, vagy a fájl, amelyet feltölteni próbálsz, túl nagy',
        'invalidfiles' => 'Egy vagy több fájl túl nagy vagy egy filetype, amely nem megengedett. Az engedélyezett fájltípusok png, gif, jpg, doc, docx, pdf és txt.',
    ),

    'import' => array(
        'error'                 => 'Egyes elemek nem importáltak helyesen.',
        'errorDetail'           => 'Az alábbi elemeket nem importálták hiba miatt.',
        'success'               => "A fájlt importálta",
        'file_delete_success'   => "A fájlt sikeresen törölték",
        'file_delete_error'      => "A fájlt nem sikerült törölni",
    ),


    'delete' => array(
        'confirm'   	=> 'Biztos benne, hogy törli ezt az elemet?',
        'error'   		=> 'Hiba történt az eszköz törlése közben. Kérlek próbáld újra.',
        'nothing_updated'   => 'Nincsenek eszközök kijelölve, így semmit sem töröltek.',
        'success' 		=> 'Az eszköz sikeresen törölve lett.'
    ),

    'checkout' => array(
        'error'   		=> 'Az eszköz nem lett kijelölve, próbáld újra',
        'success' 		=> 'A készlet sikeresen ki lett állítva.',
        'user_does_not_exist' => 'Ez a felhasználó érvénytelen. Kérlek próbáld újra.',
        'not_available' => 'Ez az eszköz nem áll rendelkezésre pénztárnál!',
        'no_assets_selected' => 'Ki kell választania legalább egy elemet a listából'
    ),

    'checkin' => array(
        'error'   		=> 'Az eszköz nem lett bejelölve, próbálkozzon újra',
        'success' 		=> 'Az Asset sikeresen ellenőrzött.',
        'user_does_not_exist' => 'Ez a felhasználó érvénytelen. Kérlek próbáld újra.',
        'already_checked_in'  => 'Ez az eszköz már be van jelölve.',

    ),

    'requests' => array(
        'error'   		=> 'Asset nem kért, kérjük, próbálkozzon újra',
        'success' 		=> 'Az eszköz sikeresen kért.',
        'canceled'      => 'A fizetési kérelem sikeresen törölve'
    )

);
