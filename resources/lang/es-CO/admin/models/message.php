<?php

return array(

    'deleted' => 'Modelo del activo eliminado',
    'does_not_exist' => 'Modelo inexistente.',
    'no_association' => 'ADVERTENCIA! El modelo del activo para este ítem es inválido o no existe!',
    'no_association_fix' => 'Esto romperá cosas de formas extrañas y horribles. Edite este activo ahora para asignarle un modelo.',
    'assoc_users'	 => 'Este modelo está asociado a uno o más equipos actualmente, por lo que no puede ser eliminado. Por favor elimina los equipos asociados, e inténtalo de nuevo. ',


    'create' => array(
        'error'   => 'El modelo no fue creado, por favor inténtalo de nuevo.',
        'success' => 'El modelo fue creado exitosamente.',
        'duplicate_set' => 'Ya existe un modelo de equipo con el mismo nombre, fabricante y número de modelo.',
    ),

    'update' => array(
        'error'   => 'El modelo no pudo ser actualizado, por favor inténtalo de nuevo',
        'success' => 'El modelo fue actualizado exitosamente.',
    ),

    'delete' => array(
        'confirm'   => '¿Estás seguro de que deseas eliminar este modelo de equipo?',
        'error'   => 'Hubo un problema eliminando el modelo. Por favor, inténtalo de nuevo.',
        'success' => 'El modelo fue eliminado exitosamente.'
    ),

    'restore' => array(
        'error'   		=> 'El modelo no pudo ser restaurado, por favor inténtalo de nuevo',
        'success' 		=> 'El modelo fue restaurado exitosamente.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Ningún campo ha cambiado, no hay nada que actualizar.',
        'success' 		=> 'Modelo actualizado correctamente. |:model_count modelos actualizados correctamente.',
        'warn'          => 'Está a punto de actualizar las propiedades del siguiente modelo: |Está a punto de editar las propiedades de los siguientes :model_count modelos:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Ningún modelo fue seleccionado, no se eliminó nada.',
        'success' 		    => 'Modelo eliminado!|:success_count modelos eliminados!',
        'success_partial' 	=> ':success_count modelos fueron eliminados, sin embargo, :fail_count no pudieron ser eliminados debido a que aún tienen equipos asociados a ellos.'
    ),

);
