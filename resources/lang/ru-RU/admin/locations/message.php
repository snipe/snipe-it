<?php

return array(

    'does_not_exist' => 'Статус актива не существует.',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this company and try again. ',
    'assoc_assets'	 => 'Это месторасположение связано как минимум с одним активом и не может быть удалено. Измените ваши активы так, чтобы они не ссылались на это месторасположение и попробуйте ещё раз. ',
    'assoc_child_loc'	 => 'У этого месторасположения является родительским и у него есть как минимум одно месторасположение уровнем ниже. Поэтому оно не может быть удалено. Обновите ваши месторасположения, так чтобы не ссылаться на него и попробуйте снова. ',
    'assigned_assets' => 'Присвоенные активы',
    'current_location' => 'Текущее местоположение',


    'create' => array(
        'error'   => 'Статус актива не был создан, попробуйте еще раз.',
        'success' => 'Статус актива успешно создан.'
    ),

    'update' => array(
        'error'   => 'Статус актива не был обновлен, попробуйте еще раз',
        'success' => 'Статус актива успешно обновлен.'
    ),

    'delete' => array(
        'confirm'   	=> 'Вы уверено, что хотите удалить этот статус?',
        'error'   => 'При удалении статуса актива произошла ошибка. Попробуйте еще раз.',
        'success' => 'Статус актива успешно удален.'
    )

);
