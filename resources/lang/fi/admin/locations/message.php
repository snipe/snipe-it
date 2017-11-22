<?php

return [

    'does_not_exist' => 'Sijaintia ei löydy.',
    'assoc_users'     => 'Sijainti on määritetty käyttöön yhdelle tai useammalle käyttäjälle joten sitä ei voida poistaa. Poista sijainti käytöstä kaikilta käyttäjiltä ja yritä uudelleen. ',
    'assoc_assets'     => 'Tällä sijainnilla on tällä hetkellä vähintään yksi omaisuus, eikä sitä voi poistaa. Päivitä varastosi, jotta et halua enää viitata tähän sijaintiin ja yritä uudelleen.',
    'assoc_child_loc'     => 'Tämä sijainti on tällä hetkellä vähintään yhden lapsen sijainnin emä, eikä sitä voi poistaa. Päivitä sijainnit, jotta et enää viitata tähän sijaintiin ja yritä uudelleen.',

    'create' => [
        'error'   => 'Sijaintia ei luotu, yritä uudelleen.',
        'success' => 'Sijainti luotiin onnistuneesti.',
    ],

    'update' => [
        'error'   => 'Sijaintia ei päivitetty, yritä uudelleen',
        'success' => 'Sijainti päivitettiin onnistuneesti.',
    ],

    'delete' => [
        'confirm'    => 'Oletko varma että haluat poistaa tämän sijainnin?',
        'error'   => 'Sijainnin poistossa tapahtui virhe. Yritä uudelleen.',
        'success' => 'Sijainti poistettiin onnistuneesti.',
    ],

];
