<?php

return array(

    'does_not_exist' => 'Model neexistuje.',
    'assoc_users'	 => 'Tento model je spojen s alespoň jedním majetkem a nemůže být smazán. Prosím smažte tyto majetky a pak to zkuste znovu. ',


    'create' => array(
        'error'   => 'Model nebyl vytvořen, zkuste to znovu.',
        'success' => 'Model byl úspěšně vytvořen.',
        'duplicate_set' => 'Model majetku s tímto názvem, výrobcem a číslem modelu již existuje.',
    ),

    'update' => array(
        'error'   => 'Model nebyl aktualizován, zkuste to prosím znovu',
        'success' => 'Model byl úspěšně aktualizován.'
    ),

    'delete' => array(
        'confirm'   => 'Opravdu si přejete tento model majetku odstranit?',
        'error'   => 'Vyskytl se problém se smazáním modelu. Zkuste to znovu.',
        'success' => 'Model byl úspěšně smazán.'
    ),

    'restore' => array(
        'error'   		=> 'Model nebyl obnoven, zkuste to prosím znovu',
        'success' 		=> 'Model byl úspěšně obnoven.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Žádné pole nebyly změněny, takže nic nebylo aktualizováno.',
        'success' 		=> 'Modely byly aktualizovány.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);
