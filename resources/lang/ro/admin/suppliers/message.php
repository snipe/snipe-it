<?php

return array(

    'does_not_exist' => 'Furnizorul nu exista.',


    'create' => array(
        'error'   => 'Furnizorul nu a fost creat, va rugam incercati iar.',
        'success' => 'Furnizorul a fost creat.'
    ),

    'update' => array(
        'error'   => 'Furnizorul nu a fost actualizat, va rugam incercati iar',
        'success' => 'Furnizorul a fost actualizat.'
    ),

    'delete' => array(
        'confirm'   => 'Sunteti sigur ca vreti sa stergeti acest furnizor?',
        'error'   => 'A aparut o problema la stergerea furnizorului. Va rugam incercati iar.',
        'success' => 'Furnizorul a fost sters.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
