<?php

return [

    'undeployable' 		=> '<strong>Atención:</strong> Este elemento ha sido marcado como no utilizable.
                        Si no es correcto, actualice el estado.',
    'does_not_exist' 	=> 'El recurso no existe.',
    'does_not_exist_var'=> 'Activo con etiqueta :asset_tag no encontrado.',
    'no_tag' 	        => 'No se ha proporcionado ninguna etiqueta de activo.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no es solicitable.',
    'assoc_users'	 	=> 'Este activo está actualmente reservado a un usuario y no puede ser eliminado. Por favor, compruebe el activo primero y vuelva a intentarlo. ',
    'warning_audit_date_mismatch' 	=> 'La próxima fecha de auditoría de este activo (:next_audit_date) es anterior a la última fecha de auditoría (:last_audit_date). Por favor, actualice la próxima fecha de auditoría.',

    'create' => [
        'error'   		=> 'El activo no fue creado, por favor, inténtelo de nuevo. :(',
        'success' 		=> 'Equipo creado con éxito. :)',
        'success_linked' => 'Activo con etiqueta :tag creado con éxito. <strong><a href=":link" style="color: white;">Haga clic aquí para ver</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Equipo no actualizado, por favor inténtalo de nuevo',
        'success' 			=> 'Equipo actualizado correctamente.',
        'encrypted_warning' => 'Activo actualizado con éxito, pero los campos personalizados cifrados no se debieron a permisos',
        'nothing_updated'	=>  'No se seleccionaron campos, por lo que no se actualizó nada.',
        'no_assets_selected'  =>  'Ningún recurso fue seleccionado, por lo que no se actualizó nada.',
        'assets_do_not_exist_or_are_invalid' => 'Los activos seleccionados no se pueden actualizar.',
    ],

    'restore' => [
        'error'   		=> 'Equipo no restaurado, por favor inténtalo de nuevo',
        'success' 		=> 'Equipo restaurado con éxito.',
        'bulk_success' 		=> 'Equipo restaurado con éxito.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se restauró nada.', 
    ],

    'audit' => [
        'error'   		=> 'Auditoría de activos fallida: :error ',
        'success' 		=> 'Auditoría de activos registrada con éxito.',
    ],


    'deletefile' => [
        'error'   => 'Archivo no eliminado. Vuelve a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ],

    'upload' => [
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
        'success' => 'Archivo(s) cargado(s) exitosamente.',
        'nofiles' => 'No seleccionó ningún archivo para ser cargado, o el archivo que está tratando de cargar es demasiado grande',
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
        'confirm'   	=> '¿Está seguro de que desea eliminar este activo?',
        'error'   		=> 'Hubo un problema al eliminar el activo. Por favor, inténtelo de nuevo.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se eliminó nada.',
        'success' 		=> 'El recurso se ha eliminado correctamente.',
    ],

    'checkout' => [
        'error'   		=> 'El activo no fue asignado, por favor inténtelo de nuevo',
        'success' 		=> 'Equipo retirado con éxito.',
        'user_does_not_exist' => 'Este usuario es inválido. Por favor, inténtalo de nuevo.',
        'not_available' => '¡Ese equipo no está disponible para asignar!',
        'no_assets_selected' => 'Debes seleccionar al menos un equipo de la lista',
    ],

    'checkin' => [
        'error'   		=> 'El equipo no se pudo devolver, por favor inténtelo de nuevo',
        'success' 		=> 'El activo fue devuelto exitosamente.',
        'user_does_not_exist' => 'Es usuario no es correcto, por favor inténtelo de nuevo.',
        'already_checked_in'  => 'El equipo ya ha sido devuelto.',

    ],

    'requests' => [
        'error'   		=> 'El equipo no pudo ser solicitado, por favor inténtalo de nuevo',
        'success' 		=> 'El equipos fue solicitado exitosamente.',
        'canceled'      => 'La solicitud de asignación fue cancelada de forma exitosa',
    ],

];
