<?php

return array(

    'does_not_exist' => 'Tokio komponento nėra.',

    'create' => array(
        'error'   => 'Komponentas nebuvo sukurtas, bandykite dar kartą.',
        'success' => 'Komponentas sukurtas sėkmingai.'
    ),

    'update' => array(
        'error'   => 'Komponentas nebuvo atnaujintas, bandykite dar kartą',
        'success' => 'Komponentas atnaujintas sėkmingai.'
    ),

    'delete' => array(
        'confirm'   => 'Ar tikrai norite panaikinti šį komponentą?',
        'error'   => 'Bandant panaikinti komponentą įvyko klaida. Bandykite dar kartą.',
        'success' => 'Komponentas panaikintas sėkmingai.',
        'error_qty'   => 'Some components of this type are still checked out. Please check them in and try again.',
    ),

     'checkout' => array(
        'error'   		=> 'Komponentas nebuvo išduotas, bandykite dar kartą',
        'success' 		=> 'Komponentas išduotas sėkmingai.',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.',
        'unavailable'      => 'Nepakanka komponentų: yra :remaining, o prašoma :requested ',
    ),

    'checkin' => array(
        'error'   		=> 'Komponentas nebuvo paimtas, bandykite dar kartą',
        'success' 		=> 'Komponentas paimtas sėkmingai.',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.'
    )


);
