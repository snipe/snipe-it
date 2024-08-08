<?php

return array(

<<<<<<< HEAD
    'does_not_exist' => 'La ubicación no existe.',
    'assoc_users'    => 'Esta ubicación no se puede eliminar actualmente porque es la ubicación de al menos un activo o de un usuario, tiene activos asignados a ella, o es la ubicación padre de otra ubicación. Por favor actualice las referencias que correspondan. ',
    'assoc_assets'	 => 'Esta ubicación está actualmente asociada con al menos un activo y no puede ser eliminada. Por favor actualice sus activos para que ya no hagan referencia a esta ubicación e inténtelo de nuevo. ',
    'assoc_child_loc'	 => 'Esta ubicación es actualmente el padre de al menos una ubicación hija y no puede ser eliminada.   Por favor actualice sus ubicaciones para que ya no hagan referencia a esta ubicación e inténtelo de nuevo. ',
    'assigned_assets' => 'Activos asignados',
    'current_location' => 'Ubicación actual',


    'create' => array(
        'error'   => 'La ubicación no pudo ser creada, por favor inténtelo de nuevo.',
        'success' => 'La ubicación fue creada exitosamente.'
    ),

    'update' => array(
        'error'   => 'La ubicación no pudo ser actualizada, por favor inténtelo de nuevo',
        'success' => 'La ubicación fue actualizada exitosamente.'
    ),

    'delete' => array(
        'confirm'   	=> '¿Está seguro de que desea eliminar esta ubicación?',
        'error'   => 'Hubo un problema eliminando la ubicación. Por favor, inténtelo de nuevo.',
        'success' => 'La ubicación fue eliminada exitosamente.'
=======
    'does_not_exist' => 'Localización no existente.',
    'assoc_users'	 => 'Esta localización está asignada al menos a un usuario y no puede ser eliminada. ',
    'assoc_assets'	 => 'Esta ubicacion se encuentra actualmente asociada con por lo menos un activo y no puede ser eliminada. Por favor, actualice sus activos para no referenciar esta ubicacion e intentelo de nuevo. ',
    'assoc_child_loc'	 => 'Esta ubicacion actualmente esta asociada con al menos una ubicacion hija y no puede ser eliminada. Por favor, actualice sus ubicaciones para no referenciar esta ubicacion e intentelo de nuevo. ',


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
>>>>>>> 64747d0fb (updates based on review)
    )

);
