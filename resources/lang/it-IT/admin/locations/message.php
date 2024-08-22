<?php

return array(

    'does_not_exist' => 'La posizione non esiste.',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this location and try again. ',
    'assoc_assets'	 => 'Questa posizione è associata ad almeno un prodotto e non può essere cancellata. Si prega di aggiornare i vostri prodotti di riferimento e riprovare. ',
    'assoc_child_loc'	 => 'Questa posizione è parente di almeno un\'altra posizione e non può essere cancellata. Si prega di aggiornare le vostre posizioni di riferimento e riprovare. ',
    'assigned_assets' => 'Beni Assegnati',
    'current_location' => 'Posizione attuale',
    'open_map' => 'Open in :map_provider_icon Maps',


    'create' => array(
        'error'   => 'La posizione non è stata creata, si prega di riprovare.',
        'success' => 'Posizione creata con successo.'
    ),

    'update' => array(
        'error'   => 'La posizione non è stata aggiornata, si prega di riprovare',
        'success' => 'Posizione aggiornata con successo.'
    ),

    'restore' => array(
        'error'   => 'Location was not restored, please try again',
        'success' => 'Location restored successfully.'
    ),

    'delete' => array(
        'confirm'   	=> 'Sei sicuro di voler cancellare questa posizione?',
        'error'   => 'C\'è stato un problema nell\'eliminare la posizione. Riprova.',
        'success' => 'Posizione eliminata con successo.'
    )

);
