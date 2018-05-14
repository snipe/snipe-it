<?php

return array(

    'does_not_exist' => 'Piegādātājs neeksistē.',


    'create' => array(
        'error'   => 'Piegādātājs netika izveidots, lūdzu, mēģiniet vēlreiz.',
        'success' => 'Piegādātājs veiksmīgi izveidots.'
    ),

    'update' => array(
        'error'   => 'Piegādātājs netika atjaunināts, lūdzu, mēģiniet vēlreiz',
        'success' => 'Piegādātājs ir veiksmīgi atjaunināts'
    ),

    'delete' => array(
        'confirm'   => 'Vai tiešām vēlaties dzēst šo piegādātāju?',
        'error'   => 'Radās problēma, izlaižot piegādātāju. Lūdzu mēģiniet vēlreiz.',
        'success' => 'Piegādātājs tika veiksmīgi dzēsts.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
