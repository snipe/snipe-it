<?php

return [

    'does_not_exist' => 'Modelo inexistente.',
    'assoc_users'	 => 'Este modelo está asociado a uno o más equipos actualmente, por lo que no puede ser eliminado. Por favor elimina los equipos asociados, e inténtalo de nuevo. ',

    'create' => [
        'error'   => 'El modelo no fue creado, por favor inténtalo de nuevo.',
        'success' => 'El modelo fue creado exitosamente.',
        'duplicate_set' => 'Ya existe un modelo de equipo con el mismo nombre, fabricante y número de modelo.',
    ],

    'update' => [
        'error'   => 'El modelo no pudo ser actualizado, por favor inténtalo de nuevo',
        'success' => 'El modelo fue actualizado exitosamente.',
    ],

    'delete' => [
        'confirm'   => '¿Estás seguro de que deseas eliminar este modelo de equipo?',
        'error'   => 'Hubo un problema eliminando el modelo. Por favor, inténtalo de nuevo.',
        'success' => 'El modelo fue eliminado exitosamente.',
    ],

    'restore' => [
        'error'   		=> 'El modelo no pudo ser restaurado, por favor inténtalo de nuevo',
        'success' 		=> 'El modelo fue restaurado exitosamente.',
    ],

    'bulkedit' => [
        'error'   		=> 'Ningún campo ha cambiado, no hay nada que actualizar.',
        'success' 		=> 'Los modelos fueron actualizados.',
    ],

    'bulkdelete' => [
        'error'   		    => 'Ningún modelo fue seleccionado, no se eliminó nada.',
        'success' 		    => '¡:success_count modelo(s) eliminado(s)!',
        'success_partial' 	=> ':success_count modelos fueron eliminados, sin embargo, :fail_count no pudieron ser eliminados debido a que aún tienen equipos asociados a ellos.',
    ],

];
