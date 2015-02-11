<?php

return array(

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Equipo inexistente.',
    'assoc_users'	 	=> 'Equipo asignado a un usuario, no se puede eliminar.',

    'create' => array(
        'error'   		=> 'Equipo no creado, intentalo de nuevo. :(',
        'success' 		=> 'Equipo creado. :)'
    ),

    'update' => array(
        'error'   		=> 'Equipo no actualizado, intentalo de nuevo',
        'success' 		=> 'Equipo actualizado.'
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.'
    ),

    'delete' => array(
        'confirm'   	=> 'Estás seguro que quieres eliminar el equipo?',
        'error'   		=> 'Equipo no eliminado, intentalo de nuevo.',
        'success' 		=> 'Equipo eliminado.'
    ),

    'checkout' => array(
        'error'   		=> 'Equipo no asignado, intentalo de nuevo',
        'success' 		=> 'Equipo asignado.',
        'user_does_not_exist' => 'Este usuario no es correcto. Intentalo de nuevo.'
    ),

    'checkin' => array(
        'error'   		=> 'No se ha quitado el equipo. Intentalo de nuevo.',
        'success' 		=> 'Equipo quitado correctamente.',
        'user_does_not_exist' => 'Este usuario no es correcto. Intentalo de nuevo.'
    )

);
