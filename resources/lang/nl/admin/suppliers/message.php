<?php

return array(

    'does_not_exist' => 'De leverancier bestaat niet.',


    'create' => array(
        'error'   => 'De leverancier is niet aangemaakt, probeer het opnieuw.',
        'success' => 'De leverancier is succesvol aangemaakt.'
    ),

    'update' => array(
        'error'   => 'De leverancier is niet gewijzigd, probeer het opnieuw',
        'success' => 'De leverancier is succesvol aangemaakt.'
    ),

    'delete' => array(
        'confirm'   => 'Ben je zeker dat je de leverancier wil verwijderen?',
        'error'   => 'Er ging iets mis tijdens het verwijderen van de leverancier. Probeer het nog een keer.',
        'success' => 'De leverancier is succesvol verwijderd.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
