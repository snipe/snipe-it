<?php

return array(

    'does_not_exist' => 'Lieferant ist nicht vorhanden.',


    'create' => array(
        'error'   => 'Lieferant wurde nicht erstellt, bitte versuchen Sie es erneut.',
        'success' => 'Lieferant wurde erfolgreich erstellt.'
    ),

    'update' => array(
        'error'   => 'Lieferant wurde nicht bearbeitet, bitte versuchen Sie es erneut',
        'success' => 'Lieferant wurde erfolgreich bearbeitet.'
    ),

    'delete' => array(
        'confirm'   => 'Sind Sie sicher, dass Sie diesen Lieferanten löschen möchten?',
        'error'   => 'Beim löschen des Lieferanten ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
        'success' => 'Lieferant wurde erfolgreich gelöscht.',
        'assoc_assets'	 => 'This supplier is currently associated with :asset_count asset(s) and cannot be deleted. Please update your assets to no longer reference this supplier and try again. ',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
