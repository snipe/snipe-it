<?php

return array(

    'does_not_exist' => 'Несъществуващ доставчик.',


    'create' => array(
        'error'   => 'Доставчикът не беше създаден. Моля, опитайте отново.',
        'success' => 'Доставчикът е създаден.'
    ),

    'update' => array(
        'error'   => 'Достъвчикът не беше обновен. Моля, опитайте отново',
        'success' => 'Доставчикът е обновен.'
    ),

    'delete' => array(
        'confirm'   => 'Сигурни ли сте, че искате да изтриете този доставчик?',
        'error'   => 'Възникна проблем при изтриване на доставчика. Моля, опитайте отново.',
        'success' => 'Доставчикът е изтрит.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
