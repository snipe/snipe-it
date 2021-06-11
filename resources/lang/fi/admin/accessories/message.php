<?php

return [

    'does_not_exist' => 'Oheistarviketta [:id] ei ole.',
    'assoc_users'	 => 'Oheistarviketta on tällä hetkellä luovutettuna :count nimikettä käyttäjille. Tarkista oheistarvikkeiden tila ja yritä uudelleen. ',

    'create' => [
        'error'   => 'Oheistarviketta ei luotu, yritä uudelleen.',
        'success' => 'Oheistarvike on luotu.',
    ],

    'update' => [
        'error'   => 'Oheistarviketta ei päivitetty, yritä uudelleen',
        'success' => 'Oheistarvike päivitettiin onnistuneesti.',
    ],

    'delete' => [
        'confirm'   => 'Haluatko varmasti poistaa tämän oheistarvikkeen?',
        'error'   => 'Oheistarvikkeen poistaminen ei onnistunut. Yritä uudelleen.',
        'success' => 'Oheistarvike poistettiin onnistuneesti.',
    ],

     'checkout' => [
        'error'   		=> 'Oheistarviketta ei luovutettu, yritä uudelleen',
        'success' 		=> 'Oheistarvike luovutettiin onnistuneesti.',
        'user_does_not_exist' => 'Käyttäjä on virheellinen. Yritä uudelleen.',
    ],

    'checkin' => [
        'error'   		=> 'Oheistarviketta ei palautettu, yritä uudelleen',
        'success' 		=> 'Oheistarvike palautettiin onnistuneesti.',
        'user_does_not_exist' => 'Kyseinen käyttäjä on virheellinen. Yritä uudelleen.',
    ],

];
