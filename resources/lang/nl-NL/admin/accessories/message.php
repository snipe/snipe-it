<?php

return array(

    'does_not_exist' => 'Het accessoire [:id] bestaat niet.',
    'not_found' => 'Dat accessoire werd niet gevonden.',
    'assoc_users'	 => 'Dit accessoire heeft op dit moment :count items uitgecheckt aan gebruikers. Check het accessoire in en probeer het opnieuw. ',

    'create' => array(
        'error'   => 'Het accessoire is niet aangemaakt. Probeer het opnieuw.',
        'success' => 'Het accessoire is aangemaakt.'
    ),

    'update' => array(
        'error'   => 'Het accessoire is niet bijgewerkt. Probeer het opnieuw.',
        'success' => 'Het accessoire is bijgewerkt.'
    ),

    'delete' => array(
        'confirm'   => 'Weet je zeker dat je dit accessoire wilt verwijderen?',
        'error'   => 'Er is een probleem opgetreden bij het verwijderen van het accessoire. Probeer het opnieuw.',
        'success' => 'Het accessoire is verwijderd.'
    ),

     'checkout' => array(
        'error'   		=> 'Het accessoire is niet uitgecheckt. Probeer het opnieuw.',
        'success' 		=> 'Het accessoire is uitgecheckt.',
        'unavailable'   => 'Accessoire kan niet worden uitgegeven. Controleer de beschikbare hoeveelheid',
        'user_does_not_exist' => 'Deze gebruiker is ongeldig. Probeer het opnieuw.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Het accessoire is niet ingecheckt. Probeer het opnieuw.',
        'success' 		=> 'Het accessoire is ingecheckt.',
        'user_does_not_exist' => 'Deze gebruiker is ongeldig. Probeer het opnieuw.'
    )


);
