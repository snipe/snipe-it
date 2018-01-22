<?php

return array(

    'does_not_exist' => 'Toimittajaa ei löydy.',


    'create' => array(
        'error'   => 'Toimittajaa ei luotu, yritä uudelleen.',
        'success' => 'Toimittaja luotiin onnistuneesti.'
    ),

    'update' => array(
        'error'   => 'Toimittajaa ei päivitetty, yritä uudelleen',
        'success' => 'Toimittaja päivitettiin onnistuneesti.'
    ),

    'delete' => array(
        'confirm'   => 'Oletko varma että haluat poistaa tämän toimittajan?',
        'error'   => 'Toimittajan poistossa tapahtui virhe. Yritä uudelleen.',
        'success' => 'Toimittaja poistettiin onnistuneesti.',
        'assoc_assets'	 => 'Tähän toimittajaan liittyy tällä hetkellä :asset_count nimikkeitä ja sitä ei voi poistaa. Ole hyvä ja päivitä nimikkeet, jotta ne eivät enää viittaa tähän toimittajaan ja yritä uudelleen. ',
        'assoc_licenses'	 => 'Tähän toimittajaan liittyy tällä hetkellä :licenses_count lisenssiä ja sitä ei voi poistaa. Ole hyvä ja päivitä lisenssit, jotta ne eivät enää viittaa tähän toimittajaan ja yritä uudelleen. ',
        'assoc_maintenances'	 => 'Tähän toimittajaan liittyy tällä hetkellä: asset_maintenances_count omaisuudenhoitoa ja sitä ei voi poistaa. Ole hyvä ja päivitä omaisuudenhoitoasi, jotta se ei enää viitata tähän toimittajaan ja yritä uudelleen. ',
    )

);
