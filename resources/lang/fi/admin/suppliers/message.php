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
        'assoc_assets'	 => 'Tämä toimittaja on yhdistetty :asset_count nimikkeisiin ja sitä ei voida poistaa. Ole hyvä ja päivttä nimikkeet jotka ovat yhdistetty tähän toimittajaan sekä yritä uudelleen. ',
        'assoc_licenses'	 => 'Tämä toimittaja on yhdistetty :licenses_count lisesseihin ja sitä ei voida poistaa. Ole hyvä ja päivitä lisenssit jotka ovat yhdistetty tähän toimittajaan sekä yritä uudelleen.  ',
        'assoc_maintenances'	 => 'Tämä toimittaja on yhdistetty :asset_maintenances_count omaisuudenhoitoon ja ei voida poistaa. Ole hyvä ja päivitä omaisuudenhoito jotka ovat yhdistetty tähän toimittajaan sekä yritä uudelleen. ',
    )

);
