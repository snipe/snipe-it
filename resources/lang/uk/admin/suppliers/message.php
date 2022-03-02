<?php

return array(

    'does_not_exist' => 'Постачальник не існує.',


    'create' => array(
        'error'   => 'Постачальник не був створений, будь ласка, повторіть спробу.',
        'success' => 'Постачальник успішно створений.'
    ),

    'update' => array(
        'error'   => 'Постачальника не було оновлено, будь ласка, спробуйте ще раз',
        'success' => 'Постачальника успішно оновлено.'
    ),

    'delete' => array(
        'confirm'   => 'Ви дійсно хочете видалити цього постачальника?',
        'error'   => 'There was an issue deleting the supplier. Please try again.',
        'success' => 'Постачальника успішно видалено.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
