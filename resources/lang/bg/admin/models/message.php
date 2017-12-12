<?php

return array(

    'does_not_exist' => 'Моделът не съществува.',
    'assoc_users'	 => 'Този модел е асоцииран с един или повече активи и не може да бъде изтрит. Моля изтрийте активите и опитайте отново.',


    'create' => array(
        'error'   => 'Моделът не беше създаден. Моля опитайте отново.',
        'success' => 'Моделът създаден успешно.',
        'duplicate_set' => 'Актив с това име, производител и номер на модел вече е въведен.',
    ),

    'update' => array(
        'error'   => 'Моделът не беше обновен. Моля опитайте отново.',
        'success' => 'Моделът обновен успешно.'
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
        'success' 		=> 'Моделите са осъвременени.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);
