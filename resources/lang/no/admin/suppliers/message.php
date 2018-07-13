<?php

return array(

    'does_not_exist' => 'Leverandør finnes ikke.',


    'create' => array(
        'error'   => 'Leverandør ble ikke opprettet. Prøv igjen.',
        'success' => 'Opprettelse av leverandør vellykket.'
    ),

    'update' => array(
        'error'   => 'Leverandør ble ikke oppdatert. Prøv igjen',
        'success' => 'Oppdatering av leverandør vellykket.'
    ),

    'delete' => array(
        'confirm'   => 'Er du sikker på at du vil slette denne leverandøren?',
        'error'   => 'Det oppstod et problem under sletting av leverandør. Prøv igjen.',
        'success' => 'Sletting av leverandør vellykket.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
