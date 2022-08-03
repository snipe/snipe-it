<?php

return array(

<<<<<<< HEAD
    'does_not_exist' => 'La licencia no existe o usted no tiene permiso para verla.',
    'user_does_not_exist' => 'El usuario no existe o no tiene permiso para verlos.',
    'asset_does_not_exist' 	=> 'El equipo que intentas asignar a esta licencia no existe.',
    'owner_doesnt_match_asset' => 'El activo que está intentando asignar con esta licencia está asignado a un usuario diferente al de la persona seleccionada de la lista.',
    'assoc_users'	 => 'Esta licencia está actualmente asignada a un usuario y no puede ser eliminada. Por favor, reciba primero la licencia y vuelva a intentarlo. ',
    'select_asset_or_person' => 'Debe seleccionar un activo o un usuario, pero no ambos.',
    'not_found' => 'Licencia no encontrada',
    'seats_available' => ':seat_count disponibles',


    'create' => array(
        'error'   => 'La licencia no fue creada, por favor inténtelo de nuevo.',
=======
    'does_not_exist' => 'Categoría inexistente.',
    'user_does_not_exist' => 'Usuario inexistente.',
    'asset_does_not_exist' 	=> 'El equipo que intentas asignar a esta licencia no existe.',
    'owner_doesnt_match_asset' => 'El equipo al que estas intentando asignar esta licenciam, está asignado a un usuario diferente que el de la licencia.',
    'assoc_users'	 => 'Esta categoría está asignada al menos a un modelo y no puede ser eliminada.',
    'select_asset_or_person' => 'Debe seleccionar un activo o un usuario, pero no ambos.',
    'not_found' => 'Licencia no encontrada',


    'create' => array(
        'error'   => 'La categoría no se ha creado, intentalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'Categoría creada correctamente.'
    ),

    'deletefile' => array(
        'error'   => 'Archivo no eliminado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ),

    'upload' => array(
<<<<<<< HEAD
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo de nuevo.',
        'success' => 'Archivo(s) cargado correctamente.',
        'nofiles' => 'No seleccionó ningún archivo para ser cargado, o el archivo que seleccionó es demasiado grande',
        'invalidfiles' => 'Uno o más de sus archivos es demasiado grande o es un tipo de archivo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml y lic.',
    ),

    'update' => array(
        'error'   => 'La licencia no fue actualizada, por favor inténtelo de nuevo',
=======
        'error'   => 'Archivo(s) no cargado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo(s) cargado correctamente.',
        'nofiles' => 'No ha seleccionado ningun archivo para ser cargado, o el archivo que seleccionó es demasiado grande',
        'invalidfiles' => 'Uno o más de tus ficheros son demasiado grandes o de un tipo no permitido. Los tipos permitidos son png, gif, jpg, doc, docx, pdf, txt, zip, rar, rtf, xml y lic.',
    ),

    'update' => array(
        'error'   => 'La categoría no se ha actualizado, intentalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'Categoría actualizada correctamente.'
    ),

    'delete' => array(
<<<<<<< HEAD
        'confirm'   => '¿Está seguro de que desea eliminar esta licencia?',
        'error'   => 'Hubo un problema al eliminar la licencia. Por favor, inténtelo de nuevo.',
=======
        'confirm'   => 'Estás seguro de eliminar esta categoría?',
        'error'   => 'Ha habido un problema eliminando la categoría. Intentalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'Categoría eliminada.'
    ),

    'checkout' => array(
<<<<<<< HEAD
        'error'   => 'Hubo un problema asignando la licencia. Por favor, inténtelo de nuevo.',
        'success' => 'La licencia fue asignada con éxito',
        'not_enough_seats' => 'No hay suficientes licencias disponibles para asignar',
        'mismatch' => 'La licencia proporcionada no coincide con la licencia seleccionada',
        'unavailable' => 'Esta licencia no está disponible para ser asignada.',
    ),

    'checkin' => array(
        'error'   => 'Hubo un problema ingresando la licencia. Por favor, inténtelo de nuevo.',
        'success' => 'La licencia fue ingresada correctamente'
=======
        'error'   => 'Equipo no asignado, intentalo de nuevo',
        'success' => 'Equipo asignado.'
    ),

    'checkin' => array(
        'error'   => 'No se ha quitado el equipo. Intentalo de nuevo.',
        'success' => 'Equipo quitado correctamente.'
>>>>>>> 64747d0fb (updates based on review)
    ),

);
