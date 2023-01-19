<?php

return [

    'undeployable' 		=> '<strong>Hoiatus: </strong> See vahend on märgitud kui kasutuselevõtmatu. Kui see olek on muutunud, palun värskendage vahendi olekut.',
    'does_not_exist' 	=> 'Vahend puudub.',
    'does_not_exist_or_not_requestable' => 'Seda vahendit ei eksisteeri või see ei ole taotletav.',
    'assoc_users'	 	=> 'Seda vara kontrollitakse kasutajale praegu ja seda ei saa kustutada. Esmalt kontrollige varast ja proovige seejärel uuesti kustutada.',

    'create' => [
        'error'   		=> 'Vahendit ei loodud, palun proovi uuesti. :(',
        'success' 		=> 'Vahendi loomine õnnestus. :)',
    ],

    'update' => [
        'error'   			=> 'Vara ei värskendatud, proovige uuesti',
        'success' 			=> 'Vara värskendati edukalt',
        'nothing_updated'	=>  'Pole ühtegi välju valitud, nii et midagi ei uuendatud.',
        'no_assets_selected'  =>  'Ühtegi vahendit ei valitud, muudatusi ei tehtud.',
    ],

    'restore' => [
        'error'   		=> 'Vara ei taastatud, palun proovi uuesti',
        'success' 		=> 'Varad on edukalt taastatud.',
    ],

    'audit' => [
        'error'   		=> 'Varade auditi ebaõnnestus. Palun proovi uuesti.',
        'success' 		=> 'Varakontrolli sisselogimisel.',
    ],


    'deletefile' => [
        'error'   => 'Faili pole kustutatud. Palun proovi uuesti.',
        'success' => 'Fail edukalt kustutatud.',
    ],

    'upload' => [
        'error'   => 'Faili (d) pole üles laaditud. Palun proovi uuesti.',
        'success' => 'Fail (id) edukalt üles laaditud.',
        'nofiles' => 'Te ei valinud üleslaadimiseks ühtegi faili või fail, mille üritate üles laadida, on liiga suur',
        'invalidfiles' => 'Üks või mitu teie faili on liiga suured või failitüüp pole lubatud. Lubatud failitüübid on png, gif, jpg, doc, docx, pdf ja txt.',
    ],

    'import' => [
        'error'                 => 'Mõned üksused ei impordinud õigesti.',
        'errorDetail'           => 'Järgmisi punkte ei imporditud vigade tõttu.',
        'success'               => 'Teie fail on imporditud',
        'file_delete_success'   => 'Teie fail on edukalt kustutatud',
        'file_delete_error'      => 'Faili ei saanud kustutada',
    ],


    'delete' => [
        'confirm'   	=> 'Kas olete kindel, et soovite selle vara kustutada?',
        'error'   		=> 'Viga kustutas. Palun proovi uuesti.',
        'nothing_updated'   => 'Varasid ei valitud, nii et midagi ei kustutatud.',
        'success' 		=> 'Varasus kustutati edukalt.',
    ],

    'checkout' => [
        'error'   		=> 'Varasid ei kontrollitud, proovige uuesti',
        'success' 		=> 'Varad võeti edukalt välja.',
        'user_does_not_exist' => 'See kasutaja on kehtetu. Palun proovi uuesti.',
        'not_available' => 'See vara pole kontrollimiseks saadaval!',
        'no_assets_selected' => 'Sa pead valima vähemalt ühe kirje nimekirjast',
    ],

    'checkin' => [
        'error'   		=> 'Vara ei olnud märgitud, palun proovi uuesti',
        'success' 		=> 'Vara on edukalt kontrollitud',
        'user_does_not_exist' => 'See kasutaja on kehtetu. Palun proovi uuesti.',
        'already_checked_in'  => 'See vara on juba sisse registreeritud.',

    ],

    'requests' => [
        'error'   		=> 'Vara ei taotletud, proovige uuesti',
        'success' 		=> 'Vara taotletud edukalt.',
        'canceled'      => 'Checkout taotlus on edukalt tühistatud',
    ],

];
