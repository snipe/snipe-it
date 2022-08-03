<?php

return array(

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
        'success' => 'Modelo eliminado.'
    ),

    'restore' => array(
        'error'   		=> 'El modelo no fue restaurado, por favor intente nuevamente',
        'success' 		=> 'Modelo restaurado exitosamente.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
        'success' 		=> 'Modelos actualizados.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Ningún modelo fue seleccionado, así que nada fue eliminado.',
        'success' 		    => '¡:success_count modelo(s) eliminado(s)!',
        'success_partial' 	=> ':success_count modelo(s) se han eliminado, sin embargo, :fail_count no se pudieron eliminar debido a que aún tienen activos asociados a ellos.'
    ),

);
