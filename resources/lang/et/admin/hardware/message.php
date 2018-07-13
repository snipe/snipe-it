<?php

return array(

    'undeployable' 		=> '<strong>Teenindus: </strong> See vara on märgitud kui praegu kasutatav. Kui see olek on muutunud, palun värskendage vara olekut.',
    'does_not_exist' 	=> 'Vahend puudub.',
    'does_not_exist_or_not_requestable' => 'Hea katse. Seda vara ei eksisteeri või see ei ole kohustuslik.',
    'assoc_users'	 	=> 'Seda vara kontrollitakse kasutajale praegu ja seda ei saa kustutada. Esmalt kontrollige varast ja proovige seejärel uuesti kustutada.',

    'create' => array(
        'error'   		=> 'Vahendit ei loodud, palun proovi uuesti. :(',
        'success' 		=> 'Vahendi loomine õnnestus. :)'
    ),

    'update' => array(
        'error'   			=> 'Vara ei värskendatud, proovige uuesti',
        'success' 			=> 'Vara värskendati edukalt',
        'nothing_updated'	=>  'Pole ühtegi välju valitud, nii et midagi ei uuendatud.',
    ),

    'restore' => array(
        'error'   		=> 'Vara ei taastatud, palun proovi uuesti',
        'success' 		=> 'Varad on edukalt taastatud.'
    ),

    'audit' => array(
        'error'   		=> 'Varade auditi ebaõnnestus. Palun proovi uuesti.',
        'success' 		=> 'Varakontrolli sisselogimisel.'
    ),


    'deletefile' => array(
        'error'   => 'Faili pole kustutatud. Palun proovi uuesti.',
        'success' => 'Fail edukalt kustutatud.',
    ),

    'upload' => array(
        'error'   => 'Faili (d) pole üles laaditud. Palun proovi uuesti.',
        'success' => 'Fail (id) edukalt üles laaditud.',
        'nofiles' => 'Te ei valinud üleslaadimiseks ühtegi faili või fail, mille üritate üles laadida, on liiga suur',
        'invalidfiles' => 'Üks või mitu teie faili on liiga suured või failitüüp pole lubatud. Lubatud failitüübid on png, gif, jpg, doc, docx, pdf ja txt.',
    ),

    'import' => array(
        'error'                 => 'Mõned üksused ei impordinud õigesti.',
        'errorDetail'           => 'Järgmisi punkte ei imporditud vigade tõttu.',
        'success'               => "Teie fail on imporditud",
        'file_delete_success'   => "Teie fail on edukalt kustutatud",
        'file_delete_error'      => "Faili ei saanud kustutada",
    ),


    'delete' => array(
        'confirm'   	=> 'Kas olete kindel, et soovite selle vara kustutada?',
        'error'   		=> 'Viga kustutas. Palun proovi uuesti.',
        'nothing_updated'   => 'Varasid ei valitud, nii et midagi ei kustutatud.',
        'success' 		=> 'Varasus kustutati edukalt.'
    ),

    'checkout' => array(
        'error'   		=> 'Varasid ei kontrollitud, proovige uuesti',
        'success' 		=> 'Varad võeti edukalt välja.',
        'user_does_not_exist' => 'See kasutaja on kehtetu. Palun proovi uuesti.',
        'not_available' => 'See vara pole kontrollimiseks saadaval!',
        'no_assets_selected' => 'You must select at least one asset from the list'
    ),

    'checkin' => array(
        'error'   		=> 'Vara ei olnud märgitud, palun proovi uuesti',
        'success' 		=> 'Vara on edukalt kontrollitud',
        'user_does_not_exist' => 'See kasutaja on kehtetu. Palun proovi uuesti.',
        'already_checked_in'  => 'See vara on juba sisse registreeritud.',

    ),

    'requests' => array(
        'error'   		=> 'Vara ei taotletud, proovige uuesti',
        'success' 		=> 'Vara taotletud edukalt.',
        'canceled'      => 'Checkout taotlus on edukalt tühistatud'
    )

);
