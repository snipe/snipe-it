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
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
