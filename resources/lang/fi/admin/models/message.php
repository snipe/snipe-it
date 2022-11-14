<?php

return array(

    'does_not_exist' => 'Malli ei löydy.',
    'assoc_users'	 => 'Tämä malli on käytössä yhdellä tai useammalla laitteella joten sitä ei voida poistaa. Poista malli käytöstä kaikilta laitteilta ja yritä uudelleen. ',


    'create' => array(
        'error'   => 'Mallia ei luotu, yritä uudelleen.',
        'success' => 'Malli luotiin onnistuneesti.',
        'duplicate_set' => 'Tämän nimen, valmistajan ja mallinumeron omaava laitemalli on jo olemassa.',
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
        'error'   		=> 'Mallia ei voitu palauttaa, yritä uudelleen',
        'success' 		=> 'Mallin palautus onnistui.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Mitään kentistä ei ollut muutettu, joten mitään ei päivitetty.',
        'success' 		=> 'Mallit päivitetty.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Ei malleja valittuna, mitään ei poistettu.',
        'success' 		    => ':success_count malli(a) poistettu!',
        'success_partial' 	=> ':success_count malli(a) poistettiin, mutta :fail_count ei voitu poistaa, koska niillä on vielä niihin liittyviä laitteita.'
    ),

);
