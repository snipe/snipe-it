<?php

return array(

    'does_not_exist' => 'Malli ei löydy.',
    'assoc_users'	 => 'Tämä malli on määritetty käyttöön yhdelle tai useammalle laitteelle joten sitä ei voida poistaa. Poista malli käytöstä kaikilta laitteilta ja yritä uudelleen. ',


    'create' => array(
        'error'   => 'Mallia ei luotu, yritä uudelleen.',
        'success' => 'Malli luotiin onnistuneesti.',
        'duplicate_set' => 'Tämän nimen, valmistajan ja mallinumeron omaava omaisuusmalli on jo olemassa.',
    ),

    'update' => array(
        'error'   => 'Mallia ei päivitetty, yritä uudelleen',
        'success' => 'Malli päivitettiin onnistuneesti.'
    ),

    'delete' => array(
        'confirm'   => 'Oletko varma että haluat poistaa tämän laitemallin?',
        'error'   => 'Laitemallin poistossa tapahtui virhe. Yritä uudelleen.',
        'success' => 'Malli poistettiin onnistuneesti.'
    ),

    'restore' => array(
        'error'   		=> 'Mallia ei palautettu, yritä uudelleen',
        'success' 		=> 'Mallin palautus onnistui.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Mitään kenttää ei muutettu, joten mitään ei päivitetä.',
        'success' 		=> 'Mallit päivitetty.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Ei malleja valittuna, mitään ei poistettu.',
        'success' 		    => ': success_count mallit poistettu!',
        'success_partial' 	=> ': success_count mallit poistettiin, mutta fail_count ei voitu poistaa, koska niillä on vielä niihin liittyviä nimikkeitä.'
    ),

);
