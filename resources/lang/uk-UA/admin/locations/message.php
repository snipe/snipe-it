<?php

return array(

    'does_not_exist' => 'Розташування не існує.',
    'assoc_users'	 => 'Розташування зараз пов\'язано як мінімум з одним користувачем та не може бути видалено. Оновіть ваших користувачів, так щоб вони не були більше пов\'язані з розташуванням і спробуйте ще раз. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',


    'create' => array(
        'error'   => 'Location was not created, please try again.',
        'success' => 'Розташування успішно створено.'
    ),

    'update' => array(
        'error'   => 'Розташування не було оновлено, спробуйте ще раз',
        'success' => 'Розташування успішно створено.'
    ),

    'delete' => array(
        'confirm'   	=> 'Ви впевнені, що хочете видати це розташування?',
        'error'   => 'There was an issue deleting the location. Please try again.',
        'success' => 'Розташування було успішно видалено.'
    )

);
