<?php

return array(

    'does_not_exist' => 'Component bestaat niet.',

    'create' => array(
        'error'   => 'Component is niet aangemaakt, probeer het nogmaals.',
        'success' => 'Component succesvol aangemaakt.'
    ),

    'update' => array(
        'error'   => 'Component is niet bijgewerkt, probeer het nogmaals.',
        'success' => 'Component succesvol bijgewerkt.'
    ),

    'delete' => array(
        'confirm'   => 'Weet je zeker dat je dit component wil verwijderen?',
        'error'   => 'Er ging iets mis bij het verwijderen van het component. Probeer het nogmaals.',
        'success' => 'Component succesvol verwijderd.',
        'error_qty'   => 'Some components of this type are still checked out. Please check them in and try again.',
    ),

     'checkout' => array(
        'error'   		=> 'Component is niet uitgecheckt, probeer het nogmaals',
        'success' 		=> 'Component succesvol uitgecheckt.',
        'user_does_not_exist' => 'Deze gebruiker is ongeldig. Probeer het opnieuw.',
        'unavailable'      => 'Er zijn niet genoeg componenten over: :resterend, :requested gevraagd ',
    ),

    'checkin' => array(
        'error'   		=> 'Component is niet ingecheckt, probeer het nogmaals',
        'success' 		=> 'Component succesvol ingecheckt.',
        'user_does_not_exist' => 'Deze gebruiker is ongeldig. Probeer het opnieuw.'
    )


);
