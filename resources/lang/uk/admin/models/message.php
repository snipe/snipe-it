<?php

return [

    'does_not_exist' => 'Модель не існує.',
    'assoc_users'	 => 'This model is currently associated with one or more assets and cannot be deleted. Please delete the assets, and then try deleting again. ',

    'create' => [
        'error'   => 'Model was not created, please try again.',
        'success' => 'Модель успішно створено.',
        'duplicate_set' => 'An asset model with that name, manufacturer and model number already exists.',
    ],

    'update' => [
        'error'   => 'Model was not updated, please try again',
        'success' => 'Model updated successfully.',
    ],

    'delete' => [
        'confirm'   => 'Ви впевнені, що хочете видалити цю модель?',
        'error'   => 'There was an issue deleting the model. Please try again.',
        'success' => 'Модель успішно видалено.',
    ],

    'restore' => [
        'error'   		=> 'Model was not restored, please try again',
        'success' 		=> 'Model restored successfully.',
    ],

    'bulkedit' => [
        'error'   		=> 'No fields were changed, so nothing was updated.',
        'success' 		=> 'Моделі оновлено.',
    ],

    'bulkdelete' => [
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.',
    ],

];
