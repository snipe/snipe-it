<?php

return [

    'does_not_exist' => 'A kategória nem létezik.',
    'assoc_models' => 'Ez a kategória jelenleg legalább egy modellhez kapcsolódik, és nem törölhető. Kérjük, frissítse a modelleket, hogy ne hivatkozzon erre a kategóriára, és próbálja újra.',
    'assoc_items' => 'Ez a kategória jelenleg legalább egy: asset_type-hez van társítva, és nem törölhető. Kérjük, frissítse a: asset_type-t, hogy ne hivatkozzon erre a kategóriára és próbálja újra.',

    'create' => [
        'error' => 'Nem sikerült a kategória létrehozása, kérjük, próbálja újra.',
        'success' => 'Sikeresen létrehozta a kategóriát.',
    ],

    'update' => [
        'error' => 'Nem sikerült a kategória módosítása, kérjük, próbálja újra',
        'success' => 'Sikeresen módosította a kategóriát.',
        'cannot_change_category_type' => 'Létrehozás után nem tudod megváltoztatni a kategória tipusát',
    ],

    'delete' => [
        'confirm' => 'Biztos benne, hogy törölni szeretné a kategóriát?',
        'error' => 'A kategória törlése közben probléma merült fel, kérjük, próbálja újra.',
        'success' => 'Kategória sikeresen törölve.',
        'bulk_success' => 'Kategória sikeresen törölve.|:count kategória sikeresen törölve lett.',
        'partial_success' => 'Kategória sikeresen törölve. További információt lejjebb talál az oldalon. | :count kategória sikeresen törlésre került. További információt lejjebb talál az oldalon.',
    ],

    'bulkedit' => [
        'warn' => 'A következő kategória tulajdonságainak szerkesztésére készül:|A következő :count kategória tulajdonságainak szerkesztésére készül:',
        'no_selection' => 'Válasszon ki legalább egy kategóriát a szerkesztéshez.',
        'no_changes' => 'Nincsenek mezők megváltoztak, így semmi sem frissült.',
        'success' => 'A kategória sikeresen frissítve.|:count kategória sikeresen frissítve.',
    ],

];
