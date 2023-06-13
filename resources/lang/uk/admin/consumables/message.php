<?php

return array(

    'does_not_exist' => 'Витратний матеріал не існує.',

    'create' => array(
        'error'   => 'Витратний матеріал не було створено, спробуйте ще раз.',
        'success' => 'Витратний матеріал успішно створено.'
    ),

    'update' => array(
        'error'   => 'Витратний матеріал не було оновлено, спробуйте ще раз',
        'success' => 'Витратний матеріал успішно оновлено.'
    ),

    'delete' => array(
        'confirm'   => 'Ви впевнені що хочете видалити цей витратний матеріал?',
        'error'   => 'There was an issue deleting the consumable. Please try again.',
        'success' => 'The consumable was deleted successfully.'
    ),

     'checkout' => array(
        'error'   		=> 'Consumable was not checked out, please try again',
        'success' 		=> 'Consumable checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
         'unavailable'      => 'There are not enough consumables for this checkout. Please check the quantity left. ',
    ),

    'checkin' => array(
        'error'   		=> 'Consumable was not checked in, please try again',
        'success' 		=> 'Consumable checked in successfully.',
        'user_does_not_exist' => 'Вказаного користувача не існує. Спробуйте ще раз.'
    )


);
