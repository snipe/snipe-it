<?php

return array(

    'does_not_exist' => 'La licencia no existe.',
    'user_does_not_exist' => 'El usuario no existe.',
    'asset_does_not_exist' 	=> 'El activo que intentas asociar con esta licencia no existe.',
    'owner_doesnt_match_asset' => 'El activo al que estás intentando asociar con esta licencia está asignado a un usuario diferente al de la persona seleccionada para retirar.',
    'assoc_users'	 => 'Esta licencia está actualmente asignada a un usuario y no puede ser borrada. Por favor, revisa la licencia primero y luego intenta borrarla. ',
    'select_asset_or_person' => 'Debes seleccionar un activo o un usuario, pero no ambos.',
    'not_found' => 'Licencia no encontrada',


    'create' => array(
        'error'   => 'La licencia no se ha creado, inténtelo de nuevo.',
        'success' => 'Licencia creada con éxito.'
    ),

    'deletefile' => array(
        'error'   => 'El archivo no fue borrado. Por favor, inténtalo de nuevo.',
        'success' => 'Archivo borrado con éxito.',
    ),

    'upload' => array(
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
        'success' => 'Archivo(s) cargado(s) con éxito.',
        'nofiles' => 'No ha seleccionado ningun archivo para ser cargado, o el archivo que seleccionó es demasiado grande',
        'invalidfiles' => 'Uno o más de tus archivos son demasiado grandes o de un tipo no permitido. Los tipos permitidos son png, gif, jpg, doc, docx, pdf, txt, zip, rar, rtf, xml y lic.',
    ),

    'update' => array(
        'error'   => 'La licencia no se ha actualizado, inténtalo de nuevo',
        'success' => 'Licencia actualizada con éxito.'
    ),

    'delete' => array(
        'confirm'   => '¿Estás seguro de querer borrar esta licencia?',
        'error'   => 'Hubo un problema al borrar la licencia. Por favor, inténtalo de nuevo.',
        'success' => 'La licencia fue eliminada con éxito.'
    ),

    'checkout' => array(
        'error'   => 'Hubo un problema asignando la licencia. Por favor, inténtelo de nuevo.',
        'success' => 'La licencia fue asignada con éxito'
    ),

    'checkin' => array(
        'error'   => 'Hubo un problema registrando la licencia. Por favor, inténtalo de nuevo.',
        'success' => 'La licencia fue registrada con éxito'
    ),

);
