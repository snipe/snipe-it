<?php

return array(

    'undeployable' 		=> '<strong>Varoitus: </strong> Tämä laite  ei ole käytettävävissä.
                        Jos laitteen tila on muuttunut, päivitä laitteen tila sen asetuksista.',
    'does_not_exist' 	=> 'Laitetta ei löydy.',
    'does_not_exist_or_not_requestable' => 'Hyvä yritys. Tätä laitetta ei ole tai se ei ole pyydettävissä.',
    'assoc_users'	 	=> 'Tämä laite on luovutettu käyttäjälle joten sitä ei voida poistaa. Palauta laite ensin käyttäjältä ja yritä uudelleen. ',

    'create' => array(
        'error'   		=> 'Laitetta ei luotu, yritä uudelleen. :(',
        'success' 		=> 'Laite luotiin onnistuneesti. :)'
    ),

    'update' => array(
        'error'   			=> 'Laitetta ei päivitetty, yritä uudelleen',
        'success' 			=> 'Laite päivitetty onnistuneesti.',
        'nothing_updated'	=>  'Mitään kenttiä ei valittu, joten mitään ei päivitetty.',
    ),

    'restore' => array(
        'error'   		=> 'Laitetta ei palautettu, ole hyvä ja yritä uudelleen',
        'success' 		=> 'Laite palautettiin onnistuneesti.'
    ),

    'audit' => array(
        'error'   		=> 'Laitteen tarkastus epäonnistui. Yritä uudelleen.',
        'success' 		=> 'Laitteen tarkastus kirjattu.'
    ),


    'deletefile' => array(
        'error'   => 'Tiedostoa ei poistettu. Ole hyvä ja yritä uudelleen.',
        'success' => 'Tiedosto poistettiin onnistuneesti.',
    ),

    'upload' => array(
        'error'   => 'Tiedostoja ei lähetetty. Ole hyvä ja yritä uudelleen.',
        'success' => 'Tiedostot lähetettiin onnistuneesti.',
        'nofiles' => 'Et ole valinnut lähetettäviä tiedostoja tai lataamasi tiedosto on liian suuri',
        'invalidfiles' => 'Yksi tai useampia tiedostoja on liian iso tai sen tiedostotyyppi ei ole sallittu. Sallitut tiedostotyypit ovat png, gif, jpg, doc, docx, pdf, ja txt.',
    ),

    'import' => array(
        'error'                 => 'Joitakin nimikkeitä ei tuotu oikein.',
        'errorDetail'           => 'Seuraavia nimikkeitä ei tuotu virheiden vuoksi.',
        'success'               => "Tiedostosi on tuotu",
        'file_delete_success'   => "Tiedosto on poistettu onnistuneesti",
        'file_delete_error'      => "Tiedostoa ei voitu poistaa",
    ),


    'delete' => array(
        'confirm'   	=> 'Oletko varma että haluat poistaa tämän laitteen?',
        'error'   		=> 'Laitteen poistamisessa tapahtui virhe. Yritä uudelleen.',
        'nothing_updated'   => 'Laitetta ei ollut valittuna, joten mitään ei poistettu.',
        'success' 		=> 'Laite poistettu onnistuneesti.'
    ),

    'checkout' => array(
        'error'   		=> 'Laitteen luovutus epäonnistui, yritä uudelleen',
        'success' 		=> 'Laite luovutettu onnistuneesti.',
        'user_does_not_exist' => 'Käyttäjä on virheellinen. Yritä uudelleen.',
        'not_available' => 'Laite ei ole luovutettavissa!',
        'no_assets_selected' => 'Valitse ainakin yksi laite listasta'
    ),

    'checkin' => array(
        'error'   		=> 'Laitteen palautus epäonnistui, yritä uudelleen',
        'success' 		=> 'Laite palautettu onnistuneesti.',
        'user_does_not_exist' => 'Käyttäjä on virheellinen. Yritä uudelleen.',
        'already_checked_in'  => 'Tämä laite on jo palautettu.',

    ),

    'requests' => array(
        'error'   		=> 'Laitetta ei pyydetty, yritä uudelleen',
        'success' 		=> 'Laitteen pyytäminen onnistui.',
        'canceled'      => 'Luovutus-pyyntö peruutettiin onnistuneesti'
    )

);
