<?php

return [

    'does_not_exist' => 'Hely nem létezik.',
    'assoc_users' => 'Ez a helyszín jelenleg nem törölhető, mert legalább egy tétel vagy felhasználó alapértelmezett helyszíne, eszközök vannak hozzá rendelve, vagy egy másik helyszín szülőhelye. Kérjük, frissítse az adatait úgy, hogy már ne hivatkozzanak erre a helyszínre, majd próbálja újra ',
    'assoc_assets' => 'Ez a hely jelenleg legalább egy eszközhöz társítva, és nem törölhető. Frissítse eszközeit, hogy ne hivatkozzon erre a helyre, és próbálja újra.',
    'assoc_child_loc' => 'Ez a hely jelenleg legalább egy gyermek helye szülője, és nem törölhető. Frissítse tartózkodási helyeit, hogy ne hivatkozzon erre a helyre, és próbálja újra.',
    'assigned_assets' => 'Hozzárendelt eszközök',
    'current_location' => 'Jelenlegi hely',
    'deleted_warning' => 'Ez a helyszín törlésre került. Kérjük, állítsa vissza, mielőtt bármilyen módosítást végezne.',

    'create' => [
        'error' => 'A helyszín nem jött létre, próbálkozzon újra.',
        'success' => 'A helyszín sikeresen létrehozva.',
    ],

    'update' => [
        'error' => 'A helyszín nem frissült, próbálkozzon újra',
        'success' => 'A helyszín sikeresen frissült.',
    ],

    'restore' => [
        'error' => 'A helyszín nem lett visszaállítva, kérjük, próbálja újra',
        'success' => 'A helyszín sikeresen visszaállítva.',
    ],

    'delete' => [
        'confirm' => 'Biztosan törölni szeretné ezt a helyet?',
        'error' => 'Hiba történt a helyszín törlése közben. Próbálja újra.',
        'success' => 'A helyszínt sikeresen törölték.',
    ],

    'bulkedit' => [
        'error' => 'Nincsenek mezők megváltoztak, így semmi sem frissült.',
        'success' => 'A hely sikeresen frissítve.|:count hely sikeresen frissítve.',
        'warn' => 'Az alábbi mezők szerkesztésével frissítheti ezt a helyet. Az üresen hagyott mezők nem változnak.|Az alábbi mezők szerkesztésével frissítheti mind a(z) :count kiválasztott helyet. Az üresen hagyott mezők egyik helyen sem változnak.',
        'show_selected' => '1 kiválasztott hely|:count kiválasztott hely',
        'company_scope_mismatch_partial' => '1 hely cége nem változott, mert az ottani tételek vagy felhasználók más cégekhez tartoznak. Először módosítsa vagy helyezze át őket.|:count hely cége nem változott, mert az ottani tételek vagy felhasználók más cégekhez tartoznak. Először módosítsa vagy helyezze át őket.',
        'company_scope_mismatch_all' => 'Egyetlen hely cége sem változott. A kért cég nem egyezik a kiválasztott hely tételeinek vagy felhasználóinak cégével.|Egyetlen hely cége sem változott. A kért cég egyik kiválasztott hely tételeinek vagy felhasználóinak cégével sem egyezik a(z) :count hely közül.',
        'parent_company_mismatch_partial' => '1 hely szülőhelye vagy cége nem változott, mert a hely így a szülőhelyétől eltérő céghez tartozna.|:count hely szülőhelye vagy cége nem változott, mert a helyek így a szülőhelyüktől eltérő céghez tartoznának.',
        'parent_company_mismatch_all' => 'Nem lett mentve módosítás. A kért szülőhely vagy cég miatt a hely a szülőhelyétől eltérő céghez tartozna.|Nem lett mentve módosítás. A kért szülőhely vagy cég miatt mind a(z) :count kiválasztott hely a szülőhelyétől eltérő céghez tartozna.',
    ],

];
