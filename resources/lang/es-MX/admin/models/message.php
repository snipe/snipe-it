<?php

return array(

<<<<<<< HEAD
    'deleted' => 'Se eliminó el modelo del activo',
    'does_not_exist' => 'Modelo inexistente.',
    'no_association' => '¡ADVERTENCIA! ¡El modelo de activo para este artículo no es válido o no existe!',
    'no_association_fix' => 'Esto causará problemas raros y horribles. Edita este activo para asignarlo a un modelo.',
    'assoc_users'	 => 'Este modelo está asociado a uno o más activos y no puede ser eliminado. Por favor, elimine los activos y vuelva a intentarlo. ',
    'invalid_category_type' => 'Esta categoría debe ser una categoría de activos.',

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
=======
    'does_not_exist' => 'Modelo inexistente.',
    'assoc_users'	 => 'Este modelo está asignado a uno o más equipos y no puede ser eliminado',


    'create' => array(
        'error'   => 'Modelo no creado, Intentalo de nuevo.',
        'success' => 'Modelo creado.',
        'duplicate_set' => 'Un modelo de activo con ese nombre, fabricante y número de modelo ya existe.',
    ),

    'update' => array(
        'error'   => 'Modelo no actualizado, Intentalo de nuevo',
        'success' => 'Modelo actualizado.'
    ),

    'delete' => array(
        'confirm'   => 'Estás seguro de querer eliminar el Modelo?',
        'error'   => 'Ha habido un problema al eliminar el Modelo. Intentalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'Modelo eliminado.'
    ),

    'restore' => array(
        'error'   		=> 'El modelo no fue restaurado, por favor intente nuevamente',
        'success' 		=> 'Modelo restaurado exitosamente.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
<<<<<<< HEAD
        'success' 		=> 'Modelo actualizado correctamente. |:model_count modelos actualizados correctamente.',
        'warn'          => 'Está a punto de actualizar las propiedades del siguiente modelo:|Está a punto de editar las propiedades de los siguientes :model_count modelos:',

=======
        'success' 		=> 'Modelos actualizados.'
>>>>>>> 64747d0fb (updates based on review)
    ),

    'bulkdelete' => array(
        'error'   		    => 'Ningún modelo fue seleccionado, así que nada fue eliminado.',
<<<<<<< HEAD
        'success' 		    => 'Modelo eliminado!|:success_count modelos eliminados!',
=======
        'success' 		    => '¡:success_count modelo(s) eliminado(s)!',
>>>>>>> 64747d0fb (updates based on review)
        'success_partial' 	=> ':success_count modelo(s) se han eliminado, sin embargo, :fail_count no se pudieron eliminar debido a que aún tienen activos asociados a ellos.'
    ),

);
