<?php

return array(

    'does_not_exist' => 'Il modello non esiste.',
    'assoc_users'	 => 'Questo modello è attualmente associato ad uno o più beni e non può essere eliminato. Eliminare i beni e poi provare a eliminare nuovamente. ',


    'create' => array(
        'error'   => 'Il modello non è stato creato, si prega di riprovare.',
        'success' => 'Modello creato con successo.',
        'duplicate_set' => 'Un modello di prodotto con quel nome, produttore e numero di modello esiste già.',
    ),

    'update' => array(
        'error'   => 'Il modello non è stato aggiornato, si prega di riprovare',
        'success' => 'Modello aggiornato con successo.'
    ),

    'delete' => array(
        'confirm'   => 'Sei sicuro di voler eliminare questo modello?',
        'error'   => 'C\'è stato un problema durante la cancellazione del modello. Riprova per favore.',
        'success' => 'Modello cancellato con successo.'
    ),

    'restore' => array(
        'error'   		=> 'Il modello non è stato ripristinato, si prega di riprovare',
        'success' 		=> 'Modello ripristinato con successo.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Nessun campo è stato modificato, quindi niente è stato aggiornato.',
        'success' 		=> 'Modelli aggiornati.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);
