<?php

return array(

    'does_not_exist' => 'Localización no existente.',
    'assoc_users'	 => 'Esta localización está asignada al menos a un usuario y no puede ser eliminada. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


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
