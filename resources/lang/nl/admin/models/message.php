<?php

return array(

    'does_not_exist' => 'Model bestaat niet.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Dit model is momenteel gekoppeld met één of meer assets en kan niet worden verwijderd. Verwijder de assets en probeer het opnieuw. ',


    'create' => array(
        'error'   => 'Model is niet aangemaakt, probeer het opnieuw.',
        'success' => 'Model is met succes aangemaakt.',
        'duplicate_set' => 'Een asset model met die naam, fabrikant en model nummer bestaat al.',
    ),

    'update' => array(
        'error'   => 'Model is niet gewijzigd, probeer het opnieuw',
        'success' => 'Model met succes gewijzigd.',
    ),

    'delete' => array(
        'confirm'   => 'Weet je het zeker dat je deze asset model wilt verwijderen?',
        'error'   => 'Er was een probleem tijden het verwijderen van dit model. Probeer het opnieuw.',
        'success' => 'Het model is met succes verwijderd.'
    ),

    'restore' => array(
        'error'   		=> 'Model is niet hersteld. Probeer opnieuw',
        'success' 		=> 'Model is met succes hersteld.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Er was geen veld geselecteerd dus is er niks gewijzigd.',
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Er waren geen modellen geselecteerd, er is dus niets verwijderd.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count model(len) werden verwijderd, maar : fail_count konden niet worden verwijderd omdat er nog steeds assets aan gekoppeld zijn.'
    ),

);
