<?php

return [

    'does_not_exist' => 'Model neexistuje.',
    'assoc_users'	 => 'Tento model je spojen s alespoň jedním majetkem a nemůže být smazán. Prosím smažte tyto majetky a pak to zkuste znovu. ',

    'create' => [
        'error'   => 'Model nebyl vytvořen, zkuste to znovu.',
        'success' => 'Model byl úspěšně vytvořen.',
        'duplicate_set' => 'Model majetku s tímto názvem, výrobcem a číslem modelu již existuje.',
    ],

    'update' => [
        'error'   => 'Model nebyl aktualizován, zkuste to prosím znovu',
        'success' => 'Model byl úspěšně aktualizován.',
    ],

    'delete' => [
        'confirm'   => 'Opravdu si přejete tento model majetku odstranit?',
        'error'   => 'Vyskytl se problém se smazáním modelu. Zkuste to znovu.',
        'success' => 'Model byl úspěšně smazán.',
    ],

    'restore' => [
        'error'   		=> 'Model nebyl obnoven, zkuste to prosím znovu',
        'success' 		=> 'Model byl úspěšně obnoven.',
    ],

    'bulkedit' => [
        'error'   		=> 'Žádné pole nebyly změněny, takže nic nebylo aktualizováno.',
        'success' 		=> 'Modely byly aktualizovány.',
    ],

    'bulkdelete' => [
        'error'   		    => 'Nebyly vybrány žádné modely, takže nebylo nic smazáno.',
        'success' 		    => ':success_count modelů smazáno!',
        'success_partial' 	=> ':success_count modelů smazáno, ale :fail_count nebylo možné smazat protože pořád mají přiřazený majetek.',
    ],

];
