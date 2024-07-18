<?php

return array(

    'does_not_exist' => 'La licencia no existe o no tiene permiso para verla.',
    'user_does_not_exist' => 'El usuario no existe o no tiene permiso para verlos.',
    'asset_does_not_exist' 	=> 'El activo que está intentando asociar con esta licencia no existe.',
    'owner_doesnt_match_asset' => 'El activo que está intentando asignar con esta licencia está asignado a un usuario diferente al de la persona seleccionada de la lista.',
    'assoc_users'	 => 'Esta licencia está actualmente reservada a un usuario y no puede ser eliminada. Por favor, compruebe la licencia en primer lugar y vuelva a intentarlo. ',
    'select_asset_or_person' => 'Debe seleccionar un activo o un usuario, pero no ambos.',
    'not_found' => 'Licencia no encontrada',
    'seats_available' => ':seat_count plazas disponibles',


    'create' => array(
        'error'   => 'La licencia no fue creada, por favor inténtalo de nuevo.',
        'success' => 'Licencia creada con éxito.'
    ),

    'deletefile' => array(
        'error'   => 'Archivo no eliminado. Vuelve a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ),

    'upload' => array(
        'error'   => 'Archivo(s) no cargados. Por favor, inténtelo de nuevo.',
        'success' => 'Archivo(s) cargados correctamente.',
        'nofiles' => 'No seleccionó ningún archivo para ser cargado, o el archivo que seleccionó es demasiado grande',
        'invalidfiles' => 'Uno o más de sus archivos es demasiado grande o es un tipo de archivo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml y lic.',
    ),

    'update' => array(
        'error'   => 'La licencia no fue actualizada, por favor inténtalo de nuevo',
        'success' => 'Licencia actualizada correctamente.'
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro de que desea eliminar esta licencia?',
        'error'   => 'Hubo un problema al eliminar la licencia. Por favor, inténtalo de nuevo.',
        'success' => 'La licencia se ha eliminado correctamente.'
    ),

    'checkout' => array(
        'error'   => 'Hubo un problema al revisar la licencia. Por favor, inténtalo de nuevo.',
        'success' => 'La licencia fue retirada con éxito',
        'not_enough_seats' => 'No hay suficientes asientos de licencia disponibles para la compra',
    ),

    'checkin' => array(
        'error'   => 'Hubo un problema devolviendo la licencia. Por favor, inténtalo de nuevo.',
        'success' => 'La licencia fue registrada con éxito'
    ),

);
