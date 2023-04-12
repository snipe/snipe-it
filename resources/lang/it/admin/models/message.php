<?php

return array(

    'does_not_exist' => 'Il modello non esiste.',
    'no_association' => 'NESSUN MODELLO ASSOCIATO.',
    'no_association_fix' => 'Ciò romperà cose in modi strani e brutti. Modifica questo bene per assegnargli un modello.',
    'assoc_users'	 => 'Questo modello è attualmente associato ad uno o più beni e non può essere eliminato. Eliminare i beni e poi provare a eliminare nuovamente. ',


    'create' => array(
        'error'   => 'Il modello non è stato creato, si prega di riprovare.',
        'success' => 'Modello creato con successo.',
        'duplicate_set' => 'Un modello di prodotto con quel nome, produttore e numero di modello esiste già.',
    ),

    'update' => array(
        'error'   => 'Il modello non è stato aggiornato, si prega di riprovare',
        'success' => 'Modello aggiornato con successo.',
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
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Non sono stati selezionati modelli, quindi non è stato eliminato nulla.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count modelli sono stati eliminati, tuttavia non è stato possibile eliminare :fail_count modelli perché dispongono ancora di risorse associate.'
    ),

);
