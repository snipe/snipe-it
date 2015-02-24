<?php

return array(

    'undeployable' 		=> '<strong>Atención: </strong> Este equipo está marcado como no isntalabre.
                        Si no es correcto, actualiza su estado.',
    'does_not_exist' 	=> 'Equipo inexistente.',
    'assoc_users'	 	=> 'Equipo asignado a un usuario, no se puede eliminar.',

    'create' => array(
        'error'   		=> 'Equipo no creado, intentalo de nuevo. :(',
        'success' 		=> 'Equipo creado. :)'
    ),

    'update' => array(
        'error'   			=> 'Equipo no actualizado, intentalo de nuevo',
        'success' 			=> 'Equipo actualizado.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.'
    ),
    
    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
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
