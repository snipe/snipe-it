<?php

return array(

    'does_not_exist' => 'Příslušenství [:id] neexistuje.',
    'not_found' => 'Toto příslušenství nebylo nalezeno.',
    'assoc_users'	 => 'Tato kategorie má nyní :count položek k předání uživatelům. Zkontrolujte převzetí příslušenství a zkuste to znovu. ',

    'create' => array(
        'error'   => 'Doplněk nebyl vytvořen, prosím zkuste to znovu.',
        'success' => 'Doplněk byl úspěšně vytvořen.'
    ),

    'update' => array(
        'error'   => 'Doplněk nebyl upraven, prosím zkuste to znovu',
        'success' => 'Doplněk byl úspěšně upraven.'
    ),

    'delete' => array(
        'confirm'   => 'Jste si jisti, že chcete odstranit toto příslušenství?',
        'error'   => 'Vyskytl se problém při mazání kategorie. Zkuste to znovu prosím.',
        'success' => 'Příslušenství bylo úspěšně odstraněno.'
    ),

     'checkout' => array(
        'error'   		=> 'Příslušenství nebylo převzato, zkuste to znovu',
        'success' 		=> 'Příslušenství úspěšně předáno.',
        'unavailable'   => 'Příslušenství nelze vydat. Zkontrolujte skladové zásoby.',
        'user_does_not_exist' => 'Neplatný uživatel. Zkuste to znovu.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Příslušenství nebylo převzato, zkuste to znovu',
        'success' 		=> 'Příslušenství úspěšně předáno.',
        'user_does_not_exist' => 'Neplatný uživatel. Zkuste to znovu.'
    )


);
