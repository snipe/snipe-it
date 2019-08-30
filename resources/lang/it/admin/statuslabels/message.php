<?php

return array(

    'does_not_exist' => 'L\'etichetta di stato non esiste.',
    'assoc_assets'	 => 'Questa etichetta di stato è attualmente associata ad almeno un Asset e non può essere cancellata.
Per favore aggiorna i tuoi Asset per togliere i riferimenti a questo stato e riprova. ',


    'create' => array(
        'error'   => 'Lo stato non è stato creato, per favore riprova.',
        'success' => 'Etichetta di stato creata correttamente.'
    ),

    'update' => array(
        'error'   => 'Lo stato non è stato aggiornato, per favore riprova',
        'success' => 'Etichetta di stato aggiornata correttamente.'
    ),

    'delete' => array(
        'confirm'   => 'Sei sicuro di voler cancellare questo stato?',
        'error'   => 'C\'è stato un problema cancellando lo stato. Per favore riprova.',
        'success' => 'L\'etichetta di stato è stata cancellata correttamente.'
    ),

    'help' => array(
        'undeployable'   => 'Queste attività non possono essere assegnate a nessuno.',
        'deployable'   => 'Queste attività possono essere verificate. Una volta assegnati, assumono uno status meta di <i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Queste attività non possono essere verificate e verranno visualizzate solo nella visualizzazione archiviata. Ciò è utile per conservare le informazioni sugli asset per finalità di bilancio o storiche ma mantenerle dall\'elenco delle attività quotidiane.',
        'pending'   => 'Queste attività non possono ancora essere assegnate a nessuno, spesso utilizzate per gli oggetti che sono fuori per la riparazione, ma si prevede di tornare alla circolazione.',
    ),

);
