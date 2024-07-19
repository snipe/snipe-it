<?php

return array(

    'does_not_exist' => 'L\'accessorio [:id] non esiste.',
    'not_found' => 'Questo accessorio non è stato trovato.',
    'assoc_users'	 => 'Questo Accessorio ha attualmente :count articoli assegnati agli utenti. Si prega di ritirare gli Accessori e riprovare. ',

    'create' => array(
        'error'   => 'L\'Accessorio non è stato creato, si prega di riprovare.',
        'success' => 'Accessorio creato con successo.'
    ),

    'update' => array(
        'error'   => 'L\'Accessorio non è stato aggiornato, si prega di riprovare',
        'success' => 'Accessorio aggiornato con successo.'
    ),

    'delete' => array(
        'confirm'   => 'Sei sicuro di voler eliminare quest\'Accessorio?',
        'error'   => 'Si è verificato un problema cercando di eliminare l\'accessorio. Si prega di riprovare.',
        'success' => 'L\'accessorio è stato eliminato con successo.'
    ),

     'checkout' => array(
        'error'   		=> 'L\'accessorio non è stato assegnato, si prega di riprovare',
        'success' 		=> 'Accessorio assegnato correttamente.',
        'unavailable'   => 'Accessorio non disponibile per l\'assegnazione. Controlla la quantità disponibile',
        'user_does_not_exist' => 'Questo utente non è valido. Riprova.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'L\'accessorio non è stato riconsegnato corretamente, si prega di riprovare',
        'success' 		=> 'Accessorio riconsegnato con successo.',
        'user_does_not_exist' => 'Questo utente non è valido. Riprova.'
    )


);
