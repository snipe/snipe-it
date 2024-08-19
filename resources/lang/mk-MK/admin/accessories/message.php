<?php

return array(

    'does_not_exist' => 'The accessory [:id] does not exist.',
    'not_found' => 'That accessory was not found.',
    'assoc_users'	 => 'Овој додаток во моментов има :count ставки задолжени на корисници. Ве молиме проверете во додатоците и обидете се повторно. ',

    'create' => array(
        'error'   => 'Додатокот не е креиран, обидете се повторно.',
        'success' => 'Додатокот беше успешно креиран.'
    ),

    'update' => array(
        'error'   => 'Додатокот не беше ажуриран, обидете се повторно',
        'success' => 'Додатокот беше успешно ажуриран.'
    ),

    'delete' => array(
        'confirm'   => 'Дали сте сигурни дека сакате да го избришете овој додаток?',
        'error'   => 'Имаше проблем со бришење на додатокот. Обидете се повторно.',
        'success' => 'Додатокот беше успешно избришан.'
    ),

     'checkout' => array(
        'error'   		=> 'Додатокот не беше задолжен, обидете се повторно',
        'success' 		=> 'Додатокот е задолжен.',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'Тој корисник е неважечки. Обидете се повторно.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Додатокот не беше раздолжен, обидете се повторно',
        'success' 		=> 'Додатокот е раздолжен.',
        'user_does_not_exist' => 'Тој корисник е неважечки. Обидете се повторно.'
    )


);
