<?php

return array(

    'does_not_exist' => 'Model neexistuje.',
    'no_association' => 'BEZ PŘIŘAZENÉHO MODELU.',
    'no_association_fix' => 'Tento stav může způsobit nedozírné problémy. Přiřaďte dotyčnému majetku správný model.',
    'assoc_users'	 => 'Tento model je spojen s alespoň jedním majetkem a nemůže být smazán. Prosím smažte tyto majetky a pak to zkuste znovu. ',


    'create' => array(
        'error'   => 'Model nebyl vytvořen, zkuste to znovu.',
        'success' => 'Model byl úspěšně vytvořen.',
        'duplicate_set' => 'Model majetku s tímto názvem, výrobcem a číslem modelu již existuje.',
    ),

    'update' => array(
        'error'   => 'Model nebyl aktualizován, zkuste to prosím znovu',
        'success' => 'Model byl úspěšně aktualizován.',
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
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Nebyly vybrány žádné modely, takže nebylo nic smazáno.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count modelů smazáno, ale :fail_count nebylo možné smazat protože pořád mají přiřazený majetek.'
    ),

);
