<?php

return array(

    'does_not_exist' => 'Ubicación inexistente.',
    'assoc_users'	 => 'La ubicación esta asociada con al menos un usuario, por lo que no puede eliminarse. Actualiza la información de tus usuarios para que no la usen, e inténtalo de nuevo. ',
    'assoc_assets'	 => 'La ubicación esta asociada con al menos un equipo, por lo que no puede eliminarse. Por favor actualiza la información de tus equipos para que no la usen, e inténtalo de nuevo. ',
    'assoc_child_loc'	 => 'La ubicación esta asociada con al menos una ubicación hija, por lo que no puede eliminarse. Actualiza la información de tus ubicaciones para desasociarlas, e inténtalo de nuevo. ',


    'create' => array(
        'error'   => 'La ubicación no pudo ser creada, por favor inténtalo de nuevo.',
        'success' => 'La ubicación fue creada exitosamente.'
    ),

    'update' => array(
        'error'   => 'La ubicación no pudo ser actualizada, por favor inténtalo de nuevo',
        'success' => 'La ubicación fue actualizada exitosamente.'
    ),

    'delete' => array(
        'confirm'   	=> '¿Estás seguro de que deseas eliminar esta ubicación?',
        'error'   => 'Hubo un problema eliminando la ubicación. Por favor, inténtalo de nuevo.',
        'success' => 'La ubicación fue eliminada exitosamente.'
    )

);
