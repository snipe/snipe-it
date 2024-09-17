<?php

return array(

    'does_not_exist' => 'Tarvik [:id] ei eksisteeri.',
    'not_found' => 'Seda tarvikut ei leitud.',
    'assoc_users'	 => 'Seda tarvikut on praegu :count väljastatud kasutajatele. Palun kontrollige tarvikuid ja proovige uuesti. ',

    'create' => array(
        'error'   => 'Tarvikut ei loodud, proovige uuesti.',
        'success' => 'See tarvik loodi edukalt.'
    ),

    'update' => array(
        'error'   => 'Tarvikut ei uuendatud. Proovige uuesti',
        'success' => 'Tarvikut uuendati edukalt.'
    ),

    'delete' => array(
        'confirm'   => 'Kas olete kindel, et soovite seda tarvikut kustutada?',
        'error'   => 'Tarvikut ei õnnestunud kustutada. Palun proovi uuesti.',
        'success' => 'Lisaseade kustutati edukalt.'
    ),

     'checkout' => array(
        'error'   		=> 'Lisatarvikut ei kontrollitud, palun proovige uuesti',
        'success' 		=> 'Lisaseade edukalt kontrollitud.',
        'unavailable'   => 'Tarvik ei ole väljastamiseks saadaval. Kontrolli laoseisu',
        'user_does_not_exist' => 'See kasutaja on kehtetu. Palun proovi uuesti.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Lisatarvikut ei olnud märgitud, palun proovige uuesti',
        'success' 		=> 'Lisaseade kontrollitud edukalt.',
        'user_does_not_exist' => 'See kasutaja on kehtetu. Palun proovi uuesti.'
    )


);
