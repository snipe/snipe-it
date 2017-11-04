<?php

return array(

    'does_not_exist' => 'Il fornitore non esiste.',


    'create' => array(
        'error'   => 'Il fornitore non è stato creato, si prega di riprovare.',
        'success' => 'Fornitore creato con successo.'
    ),

    'update' => array(
        'error'   => 'Il fornitore non è stato aggiornato, si prega di riprovare',
        'success' => 'Fornitore aggiornato con successo.'
    ),

    'delete' => array(
        'confirm'   => 'Sei sicuro di voler cancellare questo fornitore?',
        'error'   => 'C\'è stato un problema nell\'eliminazione del fornitore. Riprova.',
        'success' => 'Fornitore eliminato con successo.',
        'assoc_assets'	 => 'Questo fornitore è attualmente associato ad almeno un modello e non può essere eliminato. Si prega di aggiornare i modelli di riferimento e riprovare.',
        'assoc_licenses'	 => 'This supplier is currently associated with :licenses_count licences(s) and cannot be deleted. Please update your licenses to no longer reference this supplier and try again. ',
        'assoc_maintenances'	 => 'This supplier is currently associated with :asset_maintenances_count asset maintenances(s) and cannot be deleted. Please update your asset maintenances to no longer reference this supplier and try again. ',
    )

);
