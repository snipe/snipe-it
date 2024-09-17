<?php

return array(

    'does_not_exist' => 'La posizione non esiste.',
    'assoc_users'    => 'Non puoi eliminare questa Sede/Luogo perché è associata ad almeno un Bene o un Utente, o ha Beni assegnati, o è la Sede sotto la quale sono registrate altre Sedi. Aggiorna le altre voci in modo che non facciano più riferimento a questa Sede e poi riprova. ',
    'assoc_assets'	 => 'Questa posizione è associata ad almeno un prodotto e non può essere cancellata. Si prega di aggiornare i vostri prodotti di riferimento e riprovare. ',
    'assoc_child_loc'	 => 'Questa posizione è parente di almeno un\'altra posizione e non può essere cancellata. Si prega di aggiornare le vostre posizioni di riferimento e riprovare. ',
    'assigned_assets' => 'Beni Assegnati',
    'current_location' => 'Posizione attuale',
    'open_map' => 'Apri con :map_provider_icon Maps',


    'create' => array(
        'error'   => 'La posizione non è stata creata, si prega di riprovare.',
        'success' => 'Posizione creata con successo.'
    ),

    'update' => array(
        'error'   => 'La posizione non è stata aggiornata, si prega di riprovare',
        'success' => 'Posizione aggiornata con successo.'
    ),

    'restore' => array(
        'error'   => 'La Posizione non è stata ripristinata, si prega di riprovare',
        'success' => 'La Posizione è stata ripristinata con successo.'
    ),

    'delete' => array(
        'confirm'   	=> 'Sei sicuro di voler cancellare questa posizione?',
        'error'   => 'C\'è stato un problema nell\'eliminare la posizione. Riprova.',
        'success' => 'Posizione eliminata con successo.'
    )

);
