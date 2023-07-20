<?php

return array(

    'does_not_exist' => 'Моделът не съществува.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Този модел е асоцииран с един или повече активи и не може да бъде изтрит. Моля изтрийте активите и опитайте отново.',


    'create' => array(
        'error'   => 'Моделът не беше създаден. Моля опитайте отново.',
        'success' => 'Моделът създаден успешно.',
        'duplicate_set' => 'Актив с това име, производител и номер на модел вече е въведен.',
    ),

    'update' => array(
        'error'   => 'Моделът не беше обновен. Моля опитайте отново.',
        'success' => 'Моделът обновен успешно.',
    ),

    'delete' => array(
        'confirm'   => 'Желаете ли изтриване на модела?',
        'error'   => 'Проблем при изтриване на модела. Моля опитайте отново.',
        'success' => 'Моделът изтрит успешно.'
    ),

    'restore' => array(
        'error'   		=> 'Моделът не беше възстановен. Моля опитайте отново.',
        'success' 		=> 'Моделът възстановен успешно.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Няма полета, който да са се променили, така че нищо не е осъвременено.',
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Няма избрани модели, така че нищо не бе изтрито.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count модела бяха изтрити, но :fail_count не бяха, тъй като към тях има асоциирани активи.'
    ),

);
