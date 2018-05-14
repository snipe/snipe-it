<?php

return array(

    'does_not_exist' => 'Beszállító nem létezik.',


    'create' => array(
        'error'   => 'Beszállító nem lett létrehozva, próbálja meg újra.',
        'success' => 'A szállító sikeresen létrejött.'
    ),

    'update' => array(
        'error'   => 'Szállító nem frissült, próbálkozzon újra',
        'success' => 'Szállító sikeresen frissült.'
    ),

    'delete' => array(
        'confirm'   => 'Biztosan törölni szeretné ezt a szállítót?',
        'error'   => 'A szállító törlését okozta. Kérlek próbáld újra.',
        'success' => 'A szállító sikeresen törölve lett.',
        'assoc_assets'	 => 'Ez a beszállító jelenleg :asset_count eszközhöz van társítva és nem törölhető. Kérem frissítse az eszközeit hogy ne hivatkozzon erre a beszállítóra és próbálja újra. ',
        'assoc_licenses'	 => 'Ez a beszállító jelenleg :asset_count licenszhez van társítva és nem törölhető. Kérem frissítse az licenszeit hogy ne hivatkozzonak erre a beszállítóra és próbálja újra. ',
        'assoc_maintenances'	 => 'Ez a beszállító jelenleg :asset_maintenances_count eszköz karbantartáshoz van társítva és nem törölhető. Kérem frissítse az eszköz karbantartásait hogy ne hivatkozzon erre a beszállítóra és próbálja újra. ',
    )

);
