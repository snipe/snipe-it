<?php

return array(

    'deleted' => 'Se eliminó el modelo del activo',
    'does_not_exist' => 'Modelo inexistente.',
    'no_association' => '¡ADVERTENCIA! ¡El modelo de activo para este artículo no es válido o no existe!',
    'no_association_fix' => 'Esto romperá cosas de formas extrañas y horribles. Edite este activo ahora para asignarle un modelo.',
    'assoc_users'	 => 'Este modelo está asociado a uno o más activos y no puede ser eliminado. Por favor, elimine los activos y vuelva a intentarlo. ',
    'invalid_category_type' => 'El tipo de esta categoría debe ser categoría de activos.',

    'create' => array(
        'error'   => 'El modelo no fue creado, por favor inténtelo de nuevo.',
        'success' => 'El modelo fue creado exitosamente.',
        'duplicate_set' => 'Ya existe un modelo de equipo con el mismo nombre, fabricante y número de modelo.',
    ),

    'update' => array(
        'error'   => 'El modelo no pudo ser actualizado, por favor inténtelo de nuevo',
        'success' => 'Modelo actualizado.',
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro de que desea eliminar este modelo de activo?',
        'error'   => 'Hubo un problema eliminando el modelo. Por favor, inténtelo de nuevo.',
        'success' => 'Modelo eliminado.'
    ),

    'restore' => array(
        'error'   		=> 'El modelo no fue restaurado, por favor intente nuevamente',
        'success' 		=> 'Modelo restaurado exitosamente.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
        'success' 		=> 'Modelo actualizado correctamente. |:model_count modelos actualizados correctamente.',
        'warn'          => 'Está a punto de actualizar las propiedades del siguiente modelo:|Está a punto de editar las propiedades de los siguientes :model_count modelos:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Ningún modelo fue seleccionado, así que nada fue eliminado.',
        'success' 		    => 'Modelo eliminado!|:success_count modelos eliminados!',
        'success_partial' 	=> ':success_count modelo(s) se han eliminado, sin embargo, :fail_count no se pudieron eliminar debido a que aún tienen activos asociados a ellos.'
    ),

);
