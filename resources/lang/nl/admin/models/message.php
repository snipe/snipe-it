<?php

return array(

    'does_not_exist' => 'Model bestaat niet.',
    'no_association' => 'GEEN BIJHOREND MODEL.',
    'no_association_fix' => 'Dit zal dingen op rare en vreselijke manieren stuk maken. Bewerk deze asset nu om er een model aan toe te wijzen.',
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
        'success' 		=> 'Model succesvol bijgewerkt. |:model_count modellen succesvol bijgewerkt.',
        'warn'          => 'Je gaat de eigenschappen van het volgende model bijwerken: |Je gaat de eigenschappen bewerken van de volgende :model_count modellen:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Er waren geen modellen geselecteerd, er is dus niets verwijderd.',
        'success' 		    => 'Model verwijderd!|:success_count modellen verwijderd!',
        'success_partial' 	=> ':success_count model(len) werden verwijderd, maar : fail_count konden niet worden verwijderd omdat er nog steeds assets aan gekoppeld zijn.'
    ),

);
