<?php

return array(

    'does_not_exist' => 'Dodavatel neexistuje.',


    'create' => array(
        'error'   => 'Dodavatel nebyl vytvořen, zkuste to prosím znovu.',
        'success' => 'Dodavatel úspěšně vytvořen.'
    ),

    'update' => array(
        'error'   => 'Dodavatel nebyl aktualizován, zkuste to prosím znovu',
        'success' => 'Dodavatel úspěšně aktualizován.'
    ),

    'delete' => array(
        'confirm'   => 'Opravdu si přejete odstranit tohoto dodavatele?',
        'error'   => 'Vyskytl se problém při mazání dodavatele. Zkuste to prosím znovu.',
        'success' => 'Dodavatel byl úspěšně smazán.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
