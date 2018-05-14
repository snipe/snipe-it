<?php

return array(

    'does_not_exist' => 'Status Label existerar inte.',
    'assoc_assets'	 => 'Denna statusetikett är för närvarande associerad med minst en tillgång och kan inte raderas. Uppdatera dina tillgångar för att inte längre referera till denna status och försök igen.',


    'create' => array(
        'error'   => 'Statusetiketten skapades inte, försök igen.',
        'success' => 'Status Label skapades framgångsrikt.'
    ),

    'update' => array(
        'error'   => 'Statusetiketten uppdaterades inte, var god försök igen',
        'success' => 'Statusetiketten uppdateras framgångsrikt.'
    ),

    'delete' => array(
        'confirm'   => 'Är du säker på att du vill radera denna statusetikett?',
        'error'   => 'Det gick inte att ta bort statusetiketten. Var god försök igen.',
        'success' => 'Statusetiketten har tagits bort.'
    ),

    'help' => array(
        'undeployable'   => 'Dessa tillgångar kan inte tilldelas någon.',
        'deployable'   => 'Dessa tillgångar kan checkas ut. När de har tilldelats, antar de en metastatus på <i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Dessa tillgångar kan inte checkas ut och visas bara i arkiverad vy. Detta är användbart för att behålla information om tillgångar för budgetering / historiska ändamål men att hålla dem borta från den dagliga tillgångslistan.',
        'pending'   => 'Dessa tillgångar kan ännu inte tilldelas någon som ofta används för föremål som är ute för reparation, men förväntas återgå till omlopp.',
    ),

);
