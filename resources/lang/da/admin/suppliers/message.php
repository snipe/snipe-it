<?php

return array(

    'does_not_exist' => 'Leverandør findes ikke.',


    'create' => array(
        'error'   => 'Leverandøren blev ikke oprettet, prøv igen.',
        'success' => 'Leverandør oprettet med succes.'
    ),

    'update' => array(
        'error'   => 'Leverandøren blev ikke opdateret, prøv igen',
        'success' => 'Leverandør opdateret med succes.'
    ),

    'delete' => array(
        'confirm'   => 'Er du sikker på, at du ønsker at slette denne leverandør?',
        'error'   => 'Der opstod et problem ved at slette leverandøren. Prøv igen.',
        'success' => 'Leverandøren blev slettet med succes.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
