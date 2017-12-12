<?php

return array(

    'does_not_exist' => 'Модель не существует.',
    'assoc_users'	 => 'Данная модель связана с одним или несколькими активами, и не может быть удалена. Удалите либо измените связанные активы. ',


    'create' => array(
        'error'   => 'Модель не была создана, повторите еще раз.',
        'success' => 'Модель успешно создана.',
        'duplicate_set' => 'Модель с таким именем, производителем и номером уже существует.',
    ),

    'update' => array(
        'error'   => 'Невозможно обновить Модель, повторите еще раз',
        'success' => 'Модель успешно обновлена.'
    ),

    'delete' => array(
        'confirm'   => 'Вы уверены, что хотите удалить данную модель актива?',
        'error'   => 'При удалении модели возникла ошибка. Повторите еще раз.',
        'success' => 'Модель успешно удалена.'
    ),

    'restore' => array(
        'error'   		=> 'Модель не была восстановлена, повторите попытку',
        'success' 		=> 'Модель успешно восстановлена.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Никаких изменений нет, поэтому ничего не обновлено.',
        'success' 		=> 'Модели обновлены.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);
