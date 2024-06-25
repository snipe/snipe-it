<?php

return array(

    'does_not_exist' => 'La ubicación no existe.',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this company and try again. ',
    'assoc_assets'	 => 'Esta ubicación está actualmente asociada con al menos un activo y no puede ser borrada. Por favor actualiza tus activos para no referenciar más esta ubicación e inténtalo de nuevo. ',
    'assoc_child_loc'	 => 'Esta ubicación es actualmente padre al menos una ubicación hija y no puede ser borrada. Por favor actualiza tus ubicaciones para no referenciar más esta ubicación e inténtalo de nuevo. ',
    'assigned_assets' => 'Recursos asignados',
    'current_location' => 'Ubicación actual',


    'create' => array(
        'error'   => 'La ubicación no fue creada, por favor, inténtelo de nuevo.',
        'success' => 'Ubicación creada con éxito.'
    ),

    'update' => array(
        'error'   => 'La ubicación no fue actualizada, por favor inténtelo de nuevo',
        'success' => 'La ubicación fue actualizada con éxito.'
    ),

    'delete' => array(
        'confirm'   	=> '¿Está seguro que querer borrar esta ubicación?',
        'error'   => 'Hubo un problema borrando la ubicación. Por favor, inténtalo de nuevo.',
        'success' => 'La ubicación fue borrada con exito.'
    )

);
