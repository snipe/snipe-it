<?php

return array(

    'does_not_exist' => 'Аксесуар [:id] не існує.',
    'not_found' => 'Цей аксесуар не знайдено.',
    'assoc_users'	 => 'Наразі цей аксесуар має :count елементів відмічено користувачам. Будь ласка, перевірте аксесуари і спробуйте ще раз. ',

    'create' => array(
        'error'   => 'Аксесуар не створено, будь ласка, спробуйте ще раз.',
        'success' => 'Аксесуар успішно створено.'
    ),

    'update' => array(
        'error'   => 'Аксесуар не було оновлено, будь ласка, спробуйте ще раз',
        'success' => 'Аксесуар було успішно оновлено.'
    ),

    'delete' => array(
        'confirm'   => 'Ви впевнені, що хочете видалити цей аксесуар?',
        'error'   => 'Виникла проблема при видаленні аксесуару. Будь ласка, спробуйте ще раз.',
        'success' => 'Аксесуар успішно видалено.'
    ),

     'checkout' => array(
        'error'   		=> 'Аксесуар не був відмічений, будь ласка, спробуйте ще раз',
        'success' 		=> 'Аксесуар успішно видано.',
        'unavailable'   => 'Аксесуар недоступний для оформлення замовлення. Перевірте кількість доступних',
        'user_does_not_exist' => 'Невірний користувач. Спробуйте ще раз.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Аксесуар не було перевірено, будь ласка, спробуйте ще раз',
        'success' 		=> 'Аксесуар успішно перевірено.',
        'user_does_not_exist' => 'Вказаного користувача не існує. Спробуйте ще раз.'
    )


);
