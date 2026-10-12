<?php

return [

    'does_not_exist' => 'A licenc nem létezik, vagy nincs engedélye a megtekintéséhez.',
    'user_does_not_exist' => 'A felhasználó nem létezik, vagy nincs engedélye a megtekintéséhez.',
    'asset_does_not_exist' => 'Az eszköz, amelyet ehhez az licenchez próbál társítani, nem létezik.',
    'owner_doesnt_match_asset' => 'Az ehhez a licenchez társítani kívánt eszköz tulajdonosa nem más, mint a kiválasztott legördülő menüben kiválasztott személy.',
    'assoc_users' => 'Ez a licenc jelenleg egy felhasználónak van kiadva, ezért nem törölhető. Először ellenőrizze a licencet, majd próbálja meg újra a törlést. ',
    'select_asset_or_person' => 'Válasszon egy eszközt vagy egy felhasználót, de nem mindkettőt.',
    'not_found' => 'Licenc nem található',
    'seats_available' => 'seat_count szabad hely elérhető',

    'create' => [
        'error' => 'A licenc nem jött létre, próbálkozzon újra.',
        'success' => 'A licenc sikeresen létrehozva.',
    ],

    'deletefile' => [
        'error' => 'A fájl nem lett törölve. Próbálja újra.',
        'success' => 'A fájl sikeresen törölve.',
    ],

    'upload' => [
        'error' => 'Fel nem töltött fájl (ok). Kérlek próbáld újra.',
        'success' => 'Fájl (ok) sikeresen feltöltve.',
        'nofiles' => 'Nem választottál fel fájlokat a feltöltéshez, vagy a fájl, amelyet feltölteni próbálsz, túl nagy',
        'invalidfiles' => 'Egy vagy több fájlja túl nagy, vagy olyan fájltípus, amely nem engedélyezett. A megengedett fájltípusok a következők: png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml és lic.',
    ],

    'update' => [
        'error' => 'A licenc nem frissült, próbálkozzon újra',
        'success' => 'A licenc sikeresen frissült.',
    ],

    'delete' => [
        'confirm' => 'Biztosan törölni szeretné ezt az engedélyt?',
        'error' => 'Hiba történt az engedély törlése során. Kérlek próbáld újra.',
        'success' => 'Az engedélyt sikeresen törölték.',
        'bulk_success' => 'The selected licenses were deleted successfully.',
        'partial_success' => 'License deleted successfully. See additional information below. | :count licenses were deleted successfully. See additional information below.',
        'bulk_checkout_warning' => ':license_name has seats that are currently checked out and cannot be deleted. Please check in all seats before deleting.',
    ],

    'delete_with_checkin' => [
        'bulk_success' => ':count licenses were deleted successfully after checking in :seats seats.',
        'partial_success' => ':count licenses were deleted successfully after checking in :seats seats. See additional information below.',
    ],

    'checkout' => [
        'error' => 'Hiba történt az engedély megvizsgálásakor. Kérlek próbáld újra.',
        'success' => 'Az engedélyt sikeresen kiállították',
        'not_enough_seats' => 'Nincs elegendő licenchely a kivételhez',
        'mismatch' => 'A megadott licenchely nem egyezik a licenccel',
        'unavailable' => 'Ez a licenchely nem elérhető kivételre.',
        'license_is_inactive' => 'Ez a licenc lejárt vagy megszűnt.',
    ],

    'checkin' => [
        'error' => 'Hiba történt az engedélyben. Kérlek próbáld újra.',
        'not_reassignable' => 'A licenchely már használatban van',
        'success' => 'Az engedélyt sikeresen ellenőrizték',
    ],

    'import' => [
        'no_free_seats' => 'License ":license" has no free seats. ":target" was not assigned to a seat.',
    ],

];
