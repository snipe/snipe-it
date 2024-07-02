<?php

return array(

    'does_not_exist' => 'La posizione non esiste.',
    'assoc_users'    => 'Non puoi cancellare questa posizione perché è la posizione di almeno un bene o un utente, ha dei beni assegnati, o è la posizione principale di un\'altra posizione. Aggiornare i modelli per non fare più riferimento a questa azienda e riprovare. ',
    'assoc_assets'	 => 'Questa posizione è associata ad almeno un prodotto e non può essere cancellata. Si prega di aggiornare i vostri prodotti di riferimento e riprovare. ',
    'assoc_child_loc'	 => 'Questa posizione è parente di almeno un\'altra posizione e non può essere cancellata. Si prega di aggiornare le vostre posizioni di riferimento e riprovare. ',
    'assigned_assets' => 'Beni Assegnati',
    'current_location' => 'Posizione attuale',


    'create' => array(
        'error'   => 'La posizione non è stata creata, si prega di riprovare.',
        'success' => 'Posizione creata con successo.'
    ),

    'update' => array(
        'error'   => 'La posizione non è stata aggiornata, si prega di riprovare',
        'success' => 'Posizione aggiornata con successo.'
    ),

    'delete' => array(
        'confirm'   	=> 'Sei sicuro di voler cancellare questa posizione?',
        'error'   => 'C\'è stato un problema nell\'eliminare la posizione. Riprova.',
        'success' => 'Posizione eliminata con successo.'
    )

);
