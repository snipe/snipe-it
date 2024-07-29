<?php

return array(

    'does_not_exist' => 'A tartozék [:id] nem létezik.',
    'not_found' => 'A tartozék nem található.',
    'assoc_users'	 => 'Ebből a tartozékból jelenleg :count db van kiadva felhasználóknak. Kérem vegyen vissza tartozékot és próbálja újra! ',

    'create' => array(
        'error'   => 'A tartozék nem jött létre, kérem, próbálja újra!',
        'success' => 'A tartozék sikeresen létrejött.'
    ),

    'update' => array(
        'error'   => 'A tartozékot nem sikerült frissíteni, kérem, próbálja újra!',
        'success' => 'A tartozék sikeresen frissült.'
    ),

    'delete' => array(
        'confirm'   => 'Biztosan törölni akarja ezt a tartozékot?',
        'error'   => 'A tartozék törlése közben probléma merült fel, kérjük, próbálja újra!',
        'success' => 'A tartozék sikeresen törlődött.'
    ),

     'checkout' => array(
        'error'   		=> 'A tartozékot nem sikerült kiadni, kérem, próbálja újra!',
        'success' 		=> 'A tartozék sikeresen kiadva.',
        'unavailable'   => 'A tartozékot nem lehet kiadni. Ellenőrizd a kiadható mennyiséget',
        'user_does_not_exist' => 'Érvénytelen felhasználó. Kérem, próbálja újra!',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'A tartozékot nem sikerült visszavenni, kérem, próbálja újra!',
        'success' 		=> 'A tartozék sikeresen visszavéve.',
        'user_does_not_exist' => 'Érvénytelen felhasználó. Kérem, próbálja újra!'
    )


);
