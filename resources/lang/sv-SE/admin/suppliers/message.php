<?php

return array(

    'does_not_exist' => 'Leverantören finns inte.',


    'create' => array(
        'error'   => 'Leverantören skapades inte, var god försök igen.',
        'success' => 'Leverantören skapades framgångsrikt.'
    ),

    'update' => array(
        'error'   => 'Leverantören uppdaterades inte, var god försök igen',
        'success' => 'Leverantören uppdateras framgångsrikt.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill radera denna leverantör?',
        'error'   => 'Det var ett problem att ta bort leverantören. Var god försök igen.',
        'success' => 'Leverantören har tagits bort.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
