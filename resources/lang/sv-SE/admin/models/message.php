<?php

return [

    'does_not_exist' => 'Modellen finns inte.',
    'assoc_users'	 => 'Denna modell är redan associerad med en eller flera tillgångar och kan inte tas bort. Ta bort tillgången och försök sedan igen. ',

    'create' => [
        'error'   => 'Modellen skapades inte, försök igen.',
        'success' => 'Modellen skapad.',
        'duplicate_set' => 'En tillgångsmodell med det namnet, tillverkaren och modellnumret finns redan.',
    ],

    'update' => [
        'error'   => 'Modellen uppdaterades inte, försök igen',
        'success' => 'Modellen uppdaterad.',
    ],

    'delete' => [
        'confirm'   => 'Är du säker på att du vill ta bort denna modell?',
        'error'   => 'Problem att ta bort modellen. Försök igen.',
        'success' => 'Modellen borttagen.',
    ],

    'restore' => [
        'error'   		=> 'Modellen återskapades inte, försök igen',
        'success' 		=> 'Modellen återskapades.',
    ],

    'bulkedit' => [
        'error'   		=> 'Inga fält ändrades, så ingenting uppdaterades.',
        'success' 		=> 'Modeller uppdaterades.',
    ],

    'bulkdelete' => [
        'error'   		    => 'Inga tillgångar valdes, så ingenting togs bort.',
        'success' 		    => ': success_count modell (er) borttagen!',
        'success_partial' 	=> ':success_count modell(erna) raderades, men :fail_count kunde inte raderas eftersom de fortfarande har tillgångar kopplade till sig.',
    ],

];
