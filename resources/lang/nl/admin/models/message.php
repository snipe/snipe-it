<?php

return array(

    'does_not_exist' => 'Model bestaat niet.',
    'assoc_users'	 => 'Dit model is momenteel gekoppeld met één of meer producten en kan niet worden verwijderd. Verwijder de producten en probeer het opnieuw. ',


    'create' => array(
        'error'   => 'Model is niet aangemaakt, probeer het opnieuw.',
        'success' => 'Model is met succes aangemaakt.',
        'duplicate_set' => 'Een product model met die naam, fabrikant en model nummer bestaat al.',
    ),

    'update' => array(
        'error'   => 'Model is niet gewijzigd, probeer het opnieuw',
        'success' => 'Model met succes gewijzigd.'
    ),

    'delete' => array(
        'confirm'   => 'Weet je het zeker dat je deze product model wilt verwijderen?',
        'error'   => 'Er was een probleem tijden het verwijderen van dit model. Probeer het opnieuw.',
        'success' => 'Het model is met succes verwijderd.'
    ),

    'restore' => array(
        'error'   		=> 'Model is niet hersteld. Probeer opnieuw',
        'success' 		=> 'Model is met succes hersteld.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Er was geen veld geselecteerd dus is er niks gewijzigd.',
        'success' 		=> 'Modellen bijgewerkt.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);
