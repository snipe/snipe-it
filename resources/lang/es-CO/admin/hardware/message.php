<?php

return [

    'undeployable' 		=> 'ADVERTENCI<strong>ADVERTENCI </strong> Este activo ha sido marcado como actualmente no desplegable.
                        Si este estado ha cambiado, por favor actualice el estado del activo.',
    'does_not_exist' 	=> 'El recurso no existe.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no es solicitable.',
    'assoc_users'	 	=> 'Este activo está actualmente reservado a un usuario y no puede ser eliminado. Por favor, compruebe el activo primero y vuelva a intentarlo. ',

    'create' => [
        'error'   		=> 'El recurso no fue creado, por favor inténtalo de nuevo. :(',
        'success' 		=> 'Equipo creado con éxito. :)',
        'success_linked' => 'Activo con etiqueta :tag creado con éxito. <strong><a href=":link" style="color: white;">Haga clic aquí para ver</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Equipo no actualizado, por favor inténtalo de nuevo',
        'success' 			=> 'Equipo actualizado correctamente.',
        'nothing_updated'	=>  'No se seleccionaron campos, por lo que no se actualizó nada.',
        'no_assets_selected'  =>  'Ningún recurso fue seleccionado, por lo que no se actualizó nada.',
    ],

    'restore' => [
        'error'   		=> 'Equipo no restaurado, por favor inténtalo de nuevo',
        'success' 		=> 'Equipo restaurado con éxito.',
        'bulk_success' 		=> 'Equipo restaurado con éxito.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se restauró nada.', 
    ],

    'audit' => [
        'error'   		=> 'La auditoría de activos no tuvo éxito. Por favor, inténtalo de nuevo.',
        'success' 		=> 'Auditoría de activos registrada con éxito.',
    ],


    'deletefile' => [
        'error'   => 'Archivo no eliminado. Vuelve a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ],

    'upload' => [
        'error'   => 'Archivo(s) no cargados. Por favor, inténtelo de nuevo.',
        'success' => 'Archivo(s) cargados correctamente.',
        'nofiles' => 'No has seleccionado ningún archivo para subir, o el archivo que estás intentando subir es demasiado grande',
        'invalidfiles' => 'Uno o más de sus archivos es demasiado grande o es un tipo de archivo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf y txt.',
    ],

    'import' => [
        'error'                 => 'Algunos artículos no importaron correctamente.',
        'errorDetail'           => 'Los siguientes artículos no fueron importados debido a errores.',
        'success'               => 'Tu archivo ha sido importado',
        'file_delete_success'   => 'Su archivo se ha eliminado correctamente',
        'file_delete_error'      => 'El archivo no pudo ser eliminado',
        'file_missing' => 'Falta el archivo seleccionado',
        'header_row_has_malformed_characters' => 'Uno o más atributos en la fila del encabezado contienen caracteres UTF-8 mal formados',
        'content_row_has_malformed_characters' => 'Uno o más atributos en la primera fila de contenido contienen caracteres UTF-8 mal formados',
    ],


    'delete' => [
        'confirm'   	=> '¿Está seguro que desea eliminar este recurso?',
        'error'   		=> 'Hubo un problema al eliminar el activo. Por favor, inténtelo de nuevo.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se eliminó nada.',
        'success' 		=> 'El recurso se ha eliminado correctamente.',
    ],

    'checkout' => [
        'error'   		=> 'El recurso no fue retirado, por favor inténtalo de nuevo',
        'success' 		=> 'Equipo retirado con éxito.',
        'user_does_not_exist' => 'Este usuario es inválido. Por favor, inténtalo de nuevo.',
        'not_available' => '¡Ese equipo no está disponible para asignar!',
        'no_assets_selected' => 'Debes seleccionar al menos un equipo de la lista',
    ],

    'checkin' => [
        'error'   		=> 'El equipo no pudo ser asignado, por favor inténtalo de nuevo',
        'success' 		=> 'El equipo fue asignado exitosamente.',
        'user_does_not_exist' => 'Es usuario es invalido, por favor inténtalo de nuevo.',
        'already_checked_in'  => 'El equipo ya ha sido devuelto.',

    ],

    'requests' => [
        'error'   		=> 'El equipo no pudo ser solicitado, por favor inténtalo de nuevo',
        'success' 		=> 'El equipos fue solicitado exitosamente.',
        'canceled'      => 'La solicitud de asignación fue cancelada de forma exitosa',
    ],

];
