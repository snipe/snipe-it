<?php

return array(

    'does_not_exist' => 'La categoría no existe.',
    'assoc_models'	 => 'Esta categoría está actualmente asociada con al menos un modelo y no puede ser eliminada. Por favor actualiza tus modelos para no referenciar más esta categoría e inténtalo de nuevo. ',
    'assoc_items'	 => 'Esta categoría está actualmente asociada con al menos un: asset_type y no se puede eliminar. Por favor actualice su: asset_type para que no haga referencia a esta categoría e inténtelo de nuevo. ',

    'create' => array(
        'error'   => 'La categoría no fue creada, por favor inténtalo de nuevo.',
        'success' => 'Categoría creada con éxito.'
    ),

    'update' => array(
        'error'   => 'La categoría no se actualizó, por favor, inténtalo de nuevo',
        'success' => 'Categoría actualizada con éxito.',
        'cannot_change_category_type'   => 'No se puede cambiar el tipo de categoría una vez que se ha creado',
    ),

    'delete' => array(
        'confirm'   => '¿Estás seguro de que deseas eliminar esta categoría?',
        'error'   => 'Hubo un problema eliminando la categoría. Por favor, inténtalo de nuevo.',
        'success' => 'La categoría fue eliminada con éxito.'
    )

);
