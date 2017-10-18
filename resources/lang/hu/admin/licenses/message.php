<?php

return array(

    'does_not_exist' => 'Engedély nem létezik.',
    'user_does_not_exist' => 'Felhasználó nem létezik.',
    'asset_does_not_exist' 	=> 'A licencel társítani kívánt eszköz nem létezik.',
    'owner_doesnt_match_asset' => 'Az ehhez a licenchez társítani kívánt eszköz tulajdonosa nem más, mint a kiválasztott legördülő menüben kiválasztott személy.',
    'assoc_users'	 => 'Ez a licenc jelenleg ki van adva a felhasználónak, és nem törölhető. Kérjük, először ellenőrizze az engedélyt, majd próbálja meg újra törölni.',
    'select_asset_or_person' => 'Válasszon egy eszközt vagy egy felhasználót, de nem mindkettőt.',


    'create' => array(
        'error'   => 'A licenc nem jött létre, próbálkozzon újra.',
        'success' => 'A licenc sikeresen létrehozva.'
    ),

    'deletefile' => array(
        'error'   => 'A fájl nem törölve. Kérlek próbáld újra.',
        'success' => 'A fájl sikeresen törölve.',
    ),

    'upload' => array(
        'error'   => 'Fel nem töltött fájl (ok). Kérlek próbáld újra.',
        'success' => 'Fájl (ok) sikeresen feltöltve.',
        'nofiles' => 'Nem választottál fel fájlokat a feltöltéshez, vagy a fájl, amelyet feltölteni próbálsz, túl nagy',
        'invalidfiles' => 'Egy vagy több fájl túl nagy vagy egy filetype, amely nem megengedett. Az engedélyezett fájltípusok png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml és lic.',
    ),

    'update' => array(
        'error'   => 'A licenc nem frissült, próbálkozzon újra',
        'success' => 'A licenc sikeresen frissült.'
    ),

    'delete' => array(
        'confirm'   => 'Biztosan törölni szeretné ezt az engedélyt?',
        'error'   => 'Hiba történt az engedély törlése során. Kérlek próbáld újra.',
        'success' => 'Az engedélyt sikeresen törölték.'
    ),

    'checkout' => array(
        'error'   => 'Hiba történt az engedély megvizsgálásakor. Kérlek próbáld újra.',
        'success' => 'Az engedélyt sikeresen kiállították'
    ),

    'checkin' => array(
        'error'   => 'Hiba történt az engedélyben. Kérlek próbáld újra.',
        'success' => 'Az engedélyt sikeresen ellenőrizték'
    ),

);
