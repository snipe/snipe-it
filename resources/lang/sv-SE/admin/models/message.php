<?php

return array(

    'does_not_exist' => 'Modellen finns inte.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Denna modell är redan associerad med en eller flera tillgångar och kan inte tas bort. Ta bort tillgången och försök sedan igen. ',


    'create' => array(
        'error'   => 'Modellen skapades inte, försök igen.',
        'success' => 'Modellen skapad.',
        'duplicate_set' => 'En tillgångsmodell med det namnet, tillverkaren och modellnumret finns redan.',
    ),

    'update' => array(
        'error'   => 'Modellen uppdaterades inte, försök igen',
        'success' => 'Modellen uppdaterad.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill ta bort denna modell?',
        'error'   => 'Problem att ta bort modellen. Försök igen.',
        'success' => 'Modellen borttagen.'
    ),

    'restore' => array(
        'error'   		=> 'Modellen återskapades inte, försök igen',
        'success' 		=> 'Modellen återskapades.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Inga fält ändrades, så ingenting uppdaterades.',
        'success' 		=> 'Modeller uppdaterades.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Inga tillgångar valdes, så ingenting togs bort.',
        'success' 		    => ': success_count modell (er) borttagen!',
        'success_partial' 	=> ':success_count modell(erna) raderades, men :fail_count kunde inte raderas eftersom de fortfarande har tillgångar kopplade till sig.'
    ),

);
