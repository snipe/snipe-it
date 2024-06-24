<?php

return array(

    'does_not_exist' => 'Localización no existente.',
    'assoc_users'    => 'This location is not currently deletable because it is the location of record for at least one asset or user, has assets assigned to it, or is the parent location of another location. Please update your models to no longer reference this company and try again. ',
    'assoc_assets'	 => 'Esta ubicacion se encuentra actualmente asociada con por lo menos un activo y no puede ser eliminada. Por favor, actualice sus activos para no referenciar esta ubicacion e intentelo de nuevo. ',
    'assoc_child_loc'	 => 'Esta ubicacion actualmente esta asociada con al menos una ubicacion hija y no puede ser eliminada. Por favor, actualice sus ubicaciones para no referenciar esta ubicacion e intentelo de nuevo. ',
    'assigned_assets' => 'Recursos asignados',
    'current_location' => 'Ubicación actual',


    'create' => array(
        'error'   => 'Localización no creada, Intentalo de nuevo.',
        'success' => 'Localización creada.'
    ),

    'update' => array(
        'error'   => 'Localización no actualizada, Intentalo de nuevo',
        'success' => 'Localización actualizada.'
    ),

    'delete' => array(
        'confirm'   	=> '¿Está seguro que desea eliminar esta ubicación?',
        'error'   => 'Localización no eliminada por un problema. Intentalo de nuevo.',
        'success' => 'Localización eliminada.'
    )

);
