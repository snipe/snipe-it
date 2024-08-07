<?php

return array(

    'does_not_exist' => 'Аксесоарът [:id] не съществува.',
    'not_found' => 'Този аксесоар не е намерен.',
    'assoc_users'	 => 'От този аксесоар са предадени :count броя на потребителите. Моля впишете обратно нови или върнати и опитайте отново.',

    'create' => array(
        'error'   => 'Аксесоарът не беше създаден. Моля опитайте отново.',
        'success' => 'Аксесоарът създаден успешно.'
    ),

    'update' => array(
        'error'   => 'Аксесоарът не беше обновен. Моля опитайте отново.',
        'success' => 'Аксесоарът обновен успешно.'
    ),

    'delete' => array(
        'confirm'   => 'Сигурни ли сте, че искате да изтриете този аксесоар?',
        'error'   => 'Възникна проблем при изтриването на този аксесоар. Моля опитайте отново.',
        'success' => 'Аксесоарът бе изтрит успешно.'
    ),

     'checkout' => array(
        'error'   		=> 'Аксесоарът не беше изписан. Моля опитайте отново.',
        'success' 		=> 'Аксесоарът изписан успешно.',
        'unavailable'   => 'Аксесоарт не е наличен за изписване. Проверете наличното количество',
        'user_does_not_exist' => 'Невалиден потребител. Моля опитайте отново.',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'Аксесоарът не беше вписан. Моля опитайте отново.',
        'success' 		=> 'Аксесоарът вписан успешно.',
        'user_does_not_exist' => 'Невалиден потребител. Моля опитайте отново.'
    )


);
