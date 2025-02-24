<?php

return array(

    'does_not_exist' => 'Компонент не існує.',

    'create' => array(
        'error'   => 'Компонент не створився, спробуйте ще раз.',
        'success' => 'Компонент успішно створено.'
    ),

    'update' => array(
        'error'   => 'Компонент не оновився, спробуйте ще раз',
        'success' => 'Компонент успішно оновлено.'
    ),

    'delete' => array(
        'confirm'   => 'Ви впевнені, що хочете видалити цей компонент?',
        'error'   => 'Виникла проблема при видаленні компонента. Спробуйте ще раз.',
        'success' => 'Компонент було успішно видалено.',
        'error_qty'   => 'Some components of this type are still checked out. Please check them in and try again.',
    ),

     'checkout' => array(
        'error'   		=> 'Компонент не було видано, спробуйте ще раз',
        'success' 		=> 'Копонент успішно видано.',
        'user_does_not_exist' => 'Невірний користувач. Спробуйте ще раз.',
        'unavailable'      => 'Недостатньо компонентів, що залишилось: :remaining залишилось, :requested ',
    ),

    'checkin' => array(
        'error'   		=> 'Компонент не було видано, спробуйте ще раз',
        'success' 		=> 'Компонент успішно прийнято.',
        'user_does_not_exist' => 'Невірний користувач. Спробуйте ще раз.'
    )


);
