<?php

return array(

    'does_not_exist' => 'Priedas [:id] neegzistuoja.',
    'not_found' => 'Priedas nerastas.',
    'assoc_users'	 => 'Naudotojams išduotų šio priedo vienetų skaičius - :count. Susigrąžinkite išduotus priedus ir bandykite dar kartą. ',

    'create' => array(
        'error'   => 'Priedas nebuvo sukurtas, bandykite dar kartą.',
        'success' => 'Priedas sukurtas sėkmingai.'
    ),

    'update' => array(
        'error'   => 'Priedas nebuvo atnaujintas, bandykite dar kartą',
        'success' => 'Priedas atnaujintas sėkmingai.'
    ),

    'delete' => array(
        'confirm'   => 'Ar tikrai norite panaikinti šį priedą?',
        'error'   => 'Bandant panaikinti priedą įvyko klaida. Bandykite dar kartą.',
        'success' => 'Priedas panaikintas sėkmingai.'
    ),

     'checkout' => array(
        'error'   		=> 'Priedo nepavyko išduoti, bandykite dar kartą',
        'success' 		=> 'Priedas išduotas sėkmingai.',
        'unavailable'   => 'Priedo išduoti negalima. Patikrinkite likutį',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Priedas nebuvo paimtas, bandykite dar kartą',
        'success' 		=> 'Priedas paimtas sėkmingai.',
        'user_does_not_exist' => 'Neteisingas naudotojas. Bandykite dar kartą.'
    )


);
