<?php

return array(

    'does_not_exist' => 'Аксессуар [:id] не существует.',
    'not_found' => 'Этот аксессуар не найден.',
    'assoc_users'	 => 'Данный аксессуар выдан пользователям в количестве :count. Сделайте возврат аксессуара и попробуйте снова. ',

    'create' => array(
        'error'   => 'Аксесуар не был создан, попробуйте ещё раз.',
        'success' => 'Аксесуар успешно создан.'
    ),

    'update' => array(
        'error'   => 'Аксесуар не обновлён, попробуйте ещё раз',
        'success' => 'Аксесуар успешно обновлён.'
    ),

    'delete' => array(
        'confirm'   => 'Вы уверены, что хотите удалить этот компонент?',
        'error'   => 'Невозможно удалить компонент. Пожалуйста, попробуйте еще раз.',
        'success' => 'Копонент удален успешно.'
    ),

     'checkout' => array(
        'error'   		=> 'Ошибка при выдаче аксессуара. Повторите попытку',
        'success' 		=> 'Аксессуар успешно выдан.',
        'unavailable'   => 'Нет доступных аксессуаров для выдачи. Проверьте их количество',
        'user_does_not_exist' => 'Этот пользователь является недопустимым. Пожалуйста, попробуйте еще раз.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Ошибка при возврате аксессуара. Повторите попытку',
        'success' 		=> 'Аксессуар успешно возвращен.',
        'user_does_not_exist' => 'Этот пользователь является недопустимым. Пожалуйста, попробуйте еще раз.'
    )


);
