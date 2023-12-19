<?php

return array(

    'does_not_exist' => 'Categoría inexistente.',
    'assoc_models'	 => 'Esta categoría está asignada al menos a un modelo y no puede ser eliminada. ',
    'assoc_items'	 => 'Esta categoría está actualmente asociada con al menos uno: asset_type y no se puede eliminar. Por favor actualice su: asset_type para ya no hacer referencia a esta categoría e inténtelo de nuevo. ',

    'create' => array(
        'error'   => 'La categoría no se ha creado, intentalo de nuevo.',
        'success' => 'Categoría creada correctamente.'
    ),

    'update' => array(
        'error'   => 'La categoría no se ha actualizado, intentalo de nuevo.',
        'success' => 'Categoría actualizada correctamente.',
        'cannot_change_category_type'   => 'Una vez creado, no es posible cambiar el tipo de categoria',
    ),

    'delete' => array(
        'confirm'   => 'Estás seguro de eliminar esta categoría?',
        'error'   => 'Ha habido un problema eliminando la categoría. Intentalo de nuevo.',
        'success' => 'Categoría eliminada.'
    )

);
