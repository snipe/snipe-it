<?php

return array(

    'does_not_exist' => 'La licencia no existe o usted no tiene permiso para verla.',
    'user_does_not_exist' => 'Usuario inexistente.',
    'asset_does_not_exist' 	=> 'El equipo que intentas asignar a esta licencia no existe.',
    'owner_doesnt_match_asset' => 'El equipo al que estas intentando asignar esta licenciam, está asignado a un usuario diferente que el de la licencia.',
    'assoc_users'	 => 'Esta categoría está asignada al menos a un modelo y no puede ser eliminada.',
    'select_asset_or_person' => 'Debe seleccionar un activo o un usuario, pero no ambos.',
    'not_found' => 'Licencia no encontrada',


    'create' => array(
        'error'   => 'La categoría no se ha creado, intentalo de nuevo.',
        'success' => 'Categoría creada correctamente.'
    ),

    'deletefile' => array(
        'error'   => 'Archivo no eliminado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ),

    'upload' => array(
        'error'   => 'Archivo(s) no cargado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo(s) cargado correctamente.',
        'nofiles' => 'No ha seleccionado ningun archivo para ser cargado, o el archivo que seleccionó es demasiado grande',
        'invalidfiles' => 'Uno o más de tus ficheros son demasiado grandes o de un tipo no permitido. Los tipos permitidos son png, gif, jpg, doc, docx, pdf, txt, zip, rar, rtf, xml y lic.',
    ),

    'update' => array(
        'error'   => 'La categoría no se ha actualizado, intentalo de nuevo.',
        'success' => 'Categoría actualizada correctamente.'
    ),

    'delete' => array(
        'confirm'   => 'Estás seguro de eliminar esta categoría?',
        'error'   => 'Ha habido un problema eliminando la categoría. Intentalo de nuevo.',
        'success' => 'Categoría eliminada.'
    ),

    'checkout' => array(
        'error'   => 'Equipo no asignado, intentalo de nuevo',
        'success' => 'Equipo asignado.'
    ),

    'checkin' => array(
        'error'   => 'No se ha quitado el equipo. Intentalo de nuevo.',
        'success' => 'Equipo quitado correctamente.'
    ),

);
