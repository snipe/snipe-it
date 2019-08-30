<?php

return array(

    'does_not_exist' => 'Tarnijat ei eksisteeri.',


    'create' => array(
        'error'   => 'Tarnijat ei loodud, palun proovi uuesti.',
        'success' => 'Tarnija loomine õnnestus.'
    ),

    'update' => array(
        'error'   => 'Tarnijat ei uuendatud, palun proovi uuesti',
        'success' => 'Tarnija uuendamine õnnestus.'
    ),

    'delete' => array(
        'confirm'   => 'Kas oled kindel, et soovid selle tarnija kustutada?',
        'error'   => 'Tarnija kustutamisel tekkis probleem. Palun proovi uuesti.',
        'success' => 'Tarnija kustutamine õnnestus.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
