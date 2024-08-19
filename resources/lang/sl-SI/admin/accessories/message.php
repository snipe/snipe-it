<?php

return array(

    'does_not_exist' => 'Dodatek [:id] ne obstaja.',
    'not_found' => 'That accessory was not found.',
    'assoc_users'	 => 'Ta dodatek trenutno vsebuje: štetje predmetov, elementov ki so izdani uporabnikom. Preverite dodatke in poskusite znova. ',

    'create' => array(
        'error'   => 'Dodatek ni bila ustvarjen, poskusite znova.',
        'success' => 'Dodatek je bil uspešno ustvarjen.'
    ),

    'update' => array(
        'error'   => 'Dodatek ni bil posodobljen, poskusite znova',
        'success' => 'Dodatek je bil uspešno posodobljen.'
    ),

    'delete' => array(
        'confirm'   => 'Ali ste prepričani, da želite izbrisati ta dodatek?',
        'error'   => 'Prišlo je do napake pri brisanju dodatka. Prosim poskusite ponovno.',
        'success' => 'Dodatek je bil uspešno izbrisan.'
    ),

     'checkout' => array(
        'error'   		=> 'Dodatek ni bil izdan, poskusite znova',
        'success' 		=> 'Dodatek uspešno izdan.',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'Uporabnik je napačen. Prosim poskusite ponovno.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Dodatek ni bil sprejet, poskusite znova',
        'success' 		=> 'Dodatek uspešno sprejet.',
        'user_does_not_exist' => 'Uporabnik ne obstaja. Prosim poskusite ponovno.'
    )


);
