<?php

return array(

    'does_not_exist' => 'Dodatna oprema [:id] ne postoji.',
    'not_found' => 'That accessory was not found.',
    'assoc_users'	 => 'Ovaj pribor trenutačno ima: brojčanu stavku označenu korisnicima. Provjerite pribor i pokušajte ponovo.',

    'create' => array(
        'error'   => 'Dodatak nije izrađen, pokušajte ponovo.',
        'success' => 'Dodatak je uspješno izrađen.'
    ),

    'update' => array(
        'error'   => 'Dodatak nije ažuriran, pokušajte ponovo',
        'success' => 'Dodatak je uspješno ažuriran.'
    ),

    'delete' => array(
        'confirm'   => 'Jeste li sigurni da želite izbrisati ovaj dodatak?',
        'error'   => 'Došlo je do problema s brisanjem dodatne opreme. Molim te pokušaj ponovno.',
        'success' => 'Dodatak je uspješno izbrisan.'
    ),

     'checkout' => array(
        'error'   		=> 'Dodatak nije provjeren, pokušajte ponovo',
        'success' 		=> 'Usluga je uspješno provjerena.',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'Taj je korisnik nevažeći. Molim te pokušaj ponovno.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Dodatna oprema nije prijavljena, pokušajte ponovo',
        'success' 		=> 'Pristup je uspješno prijavljen.',
        'user_does_not_exist' => 'Taj je korisnik nevažeći. Molim te pokušaj ponovno.'
    )


);
