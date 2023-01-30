<?php

return array(

    'does_not_exist' => 'Sijaintia ei löydy.',
    'assoc_users'	 => 'Sijainti on määritetty käyttöön yhdelle tai useammalle käyttäjälle joten sitä ei voida poistaa. Poista sijainti käytöstä kaikilta käyttäjiltä ja yritä uudelleen. ',
    'assoc_assets'	 => 'Sijaintiin on tällä hetkellä liitettynä vähintään yksi laite, eikä sitä voi poistaa. Poista viittaus sijantiin ja yritä uudelleen. ',
    'assoc_child_loc'	 => 'Tämä sijainti on ylempi toiselle sijainnille eikä sitä voi poistaa. Päivitä sijainnit, jotta et enää viitata tähän sijaintiin ja yritä uudelleen. ',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',


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
