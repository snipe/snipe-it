<?php

return array(

    'does_not_exist' => 'Modelo inexistente.',
    'no_association' => 'NINGUN MODELO ASOCIADO.',
    'no_association_fix' => 'Esto causará problemas raros y horribles. Edita este activo para asignarlo a un modelo.',
    'assoc_users'	 => 'Este modelo está asignado a uno o más equipos y no puede ser eliminado',


    'create' => array(
        'error'   => 'Modelo no creado, Intentalo de nuevo.',
        'success' => 'Modelo creado.',
        'duplicate_set' => 'Un modelo de activo con ese nombre, fabricante y número de modelo ya existe.',
    ),

    'update' => array(
        'error'   => 'Modelo no actualizado, Intentalo de nuevo',
        'success' => 'Modelo actualizado.',
    ),

    'delete' => array(
        'confirm'   => 'Estás seguro de querer eliminar el Modelo?',
        'error'   => 'Ha habido un problema al eliminar el Modelo. Intentalo de nuevo.',
        'success' => 'Modelo eliminado.'
    ),

    'restore' => array(
        'error'   		=> 'El modelo no fue restaurado, por favor intente nuevamente',
        'success' 		=> 'Modelo restaurado exitosamente.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
        'success' 		=> 'Modelo actualizado correctamente. |:model_count modelos actualizados correctamente.',
        'warn'          => 'Está a punto de actualizar las propiedades del siguiente modelo: |Está a punto de editar las propiedades de los siguientes :model_count modelos:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Ningún modelo fue seleccionado, así que nada fue eliminado.',
        'success' 		    => 'Modelo eliminado!|:success_count modelos eliminados!',
        'success_partial' 	=> ':success_count modelo(s) se han eliminado, sin embargo, :fail_count no se pudieron eliminar debido a que aún tienen activos asociados a ellos.'
    ),

);
