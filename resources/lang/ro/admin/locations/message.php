<?php

return array(

    'does_not_exist' => 'Locatia nu exista.',
    'assoc_users'	 => 'Aceasta locatie este momentan asociata cu cel putin inca un alt utilizator si nu poate fi stearsa. Va rugam actualizati utilizatorii care nu mai apartin de aceasta locatie si incercati iar. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


    'create' => array(
        'error'   => 'Locatia nu a fost creata, va rugam incercati iar.',
        'success' => 'Locatia a fost creata.'
    ),

    'update' => array(
        'error'   => 'Locatia nu a fost actualizata, va rugam incercati iar',
        'success' => 'Locatia a fost actualizata.'
    ),

    'delete' => array(
        'confirm'   	=> 'Sunteti sigur ca vreti sa stergeti aceasta locatie?',
        'error'   => 'A aparut o problema la stergerea locatiei. Va rugam incercati iar.',
        'success' => 'Locatia a fost stearsa.'
    )

);
