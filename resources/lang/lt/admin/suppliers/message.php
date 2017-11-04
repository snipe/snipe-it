<?php

return array(

    'does_not_exist' => 'Tokio tiekėjo nėra.',


    'create' => array(
        'error'   => 'Tiekėjas nesukurtas. Prašome bandykite dar kartą.',
        'success' => 'Tiekėjas sėkmingai sukurtas.'
    ),

    'update' => array(
        'error'   => 'Tiekėjas neatnaujintas. Prašome bandykite dar kartą',
        'success' => 'Tiekėjas sėkmingai atnaujintas.'
    ),

    'delete' => array(
        'confirm'   => 'Ar jūs tikrai norite ištrinti šį tiekėją?',
        'error'   => 'Nepavyko ištrinti tiekėjo. Prašome bandykite dar kartą.',
        'success' => 'Tiekėjas ištrintas sėkmingai.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
