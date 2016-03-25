<?php

return array(

    'does_not_exist' => 'Sijaintia ei löydy.',
    'assoc_users'	 => 'Sijainti on määritetty käyttöön yhdelle tai useammalle käyttäjälle joten sitä ei voida poistaa. Poista sijainti käytöstä kaikilta käyttäjiltä ja yritä uudelleen. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


    'create' => array(
        'error'   => 'Sijaintia ei luotu, yritä uudelleen.',
        'success' => 'Sijainti luotiin onnistuneesti.'
    ),

    'update' => array(
        'error'   => 'Sijaintia ei päivitetty, yritä uudelleen',
        'success' => 'Sijainti päivitettiin onnistuneesti.'
    ),

    'delete' => array(
        'confirm'   	=> 'Oletko varma että haluat poistaa tämän sijainnin?',
        'error'   => 'Sijainnin poistossa tapahtui virhe. Yritä uudelleen.',
        'success' => 'Sijainti poistettiin onnistuneesti.'
    )

);
