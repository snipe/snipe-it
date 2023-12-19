<?php

return array(

    'does_not_exist' => 'Förbrukningsartiklar existerar inte.',

    'create' => array(
        'error'   => 'Förbrukningsbarhet skapades inte, försök igen.',
        'success' => 'Förbrukningsbar skapad framgångsrik.'
    ),

    'update' => array(
        'error'   => 'Förbrukningsvaror uppdaterades inte, var god försök igen',
        'success' => 'Förbrukningsvaror uppdateras framgångsrikt.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill radera denna förbrukningsartiklar?',
        'error'   => 'Det gick inte att ta bort förbrukningen. Var god försök igen.',
        'success' => 'Konsumtionen har tagits bort.'
    ),

     'checkout' => array(
        'error'   		=> 'Förbrukningsartiklarna är inte utcheckade, försök igen',
        'success' 		=> 'Förbrukningsbar utcheckad framgångsrik.',
        'user_does_not_exist' => 'Den användaren är ogiltig. Var god försök igen.',
         'unavailable'      => 'Det finns inte tillräckligt med förbrukningsvaror för denna checkout. Vänligen kontrollera antalet kvar. ',
    ),

    'checkin' => array(
        'error'   		=> 'Förbrukningsartiklarna kontrollerades inte, försök igen',
        'success' 		=> 'Konsumtionskontrollen kontrolleras framgångsrikt.',
        'user_does_not_exist' => 'Den användaren är ogiltig. Var god försök igen.'
    )


);
