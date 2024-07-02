<?php

return [

    'undeployable' 		=> '<strong>Atención:</strong> Este elemento ha sido marcado como no utilizable.
                        Si no es correcto, actualice el estado.',
    'does_not_exist' 	=> 'El activo no existe.',
    'does_not_exist_var'=> 'Activo con etiqueta :asset_tag no encontrado.',
    'no_tag' 	        => 'No se ha proporcionado ninguna etiqueta de activo.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no es solicitable.',
    'assoc_users'	 	=> 'Este activo está actualmente asignado a un usuario y no puede ser borrado. Por favor, revisa el activo primero y luego intenta borrarlo. ',
    'warning_audit_date_mismatch' 	=> 'La próxima fecha de auditoría de este activo (:next_audit_date) es anterior a la última fecha de auditoría (:last_audit_date). Por favor, actualice la próxima fecha de auditoría.',

    'create' => [
        'error'   		=> 'El activo no fue creado, por favor, inténtelo de nuevo. :(',
        'success' 		=> 'Activo creado con éxito. :)',
        'success_linked' => 'Activo con etiqueta :tag creado con éxito. <strong><a href=":link" style="color: white;">Haga clic aquí para ver</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Activo no ha sido actualizado, por favor, inténtelo de nuevo',
        'success' 			=> 'Activo actualizado con éxito.',
        'encrypted_warning' => 'Activo actualizado con éxito, pero los campos personalizados cifrados no se debieron a permisos',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, así que nada se actualizó.',
        'no_assets_selected'  =>  'Ningún recurso fue seleccionado, por lo que no se actualizó nada.',
        'assets_do_not_exist_or_are_invalid' => 'Los activos seleccionados no se pueden actualizar.',
    ],

    'restore' => [
        'error'   		=> 'El activo no fue restaurado, por favor, inténtalo de nuevo',
        'success' 		=> 'Activo restaurado correctamente.',
        'bulk_success' 		=> 'Activo restaurado correctamente.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se restauró nada.', 
    ],

    'audit' => [
        'error'   		=> 'Auditoría de activos fallida: :error ',
        'success' 		=> 'Audoría de activo registrada con éxito.',
    ],


    'deletefile' => [
        'error'   => 'El archivo no fue borrado. Por favor, inténtalo de nuevo.',
        'success' => 'Archivo borrado con éxito.',
    ],

    'upload' => [
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
        'success' => 'Archivo(s) cargado(s) exitosamente.',
        'nofiles' => 'No seleccionó ningún archivo para ser cargado, o el archivo que está tratando de cargar es demasiado grande',
        'invalidfiles' => 'Uno o más de tus archivos es demasiado grande o es de un tipo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf, y txt.',
    ],

    'import' => [
        'error'                 => 'Algunos de los elementos no se importaron correctamente.',
        'errorDetail'           => 'Lo siguientes elementos no se importaron debido a errores.',
        'success'               => 'Tu archivo ha sido importado',
        'file_delete_success'   => 'Tu archivo ha sido eliminado con éxito',
        'file_delete_error'      => 'El archivo no se pudo eliminar',
        'file_missing' => 'Falta el archivo seleccionado',
        'header_row_has_malformed_characters' => 'Uno o más atributos en la fila del encabezado contienen caracteres UTF-8 mal formados',
        'content_row_has_malformed_characters' => 'Uno o más atributos en la primera fila de contenido contienen caracteres UTF-8 mal formados',
    ],


    'delete' => [
        'confirm'   	=> '¿Está seguro de que desea eliminar este activo?',
        'error'   		=> 'Ha habido un problema eliminando el activo. Por favor, inténtelo de nuevo.',
        'nothing_updated'   => 'Ningún activo se seleccionó, así que nada fue borrado.',
        'success' 		=> 'El activo fue borrado con éxito.',
    ],

    'checkout' => [
        'error'   		=> 'El activo no fue asignado, por favor inténtelo de nuevo',
        'success' 		=> 'Activo asignado con éxito.',
        'user_does_not_exist' => 'El usuario es inválido. Por favor, inténtelo de nuevo.',
        'not_available' => '¡Ese activo no está disponible para retirar!',
        'no_assets_selected' => 'Debes seleccionar al menos un activo de la lista',
    ],

    'checkin' => [
        'error'   		=> 'El equipo no se pudo devolver, por favor inténtelo de nuevo',
        'success' 		=> 'El activo fue devuelto exitosamente.',
        'user_does_not_exist' => 'Es usuario no es correcto, por favor inténtelo de nuevo.',
        'already_checked_in'  => 'El equipo ya ha sido devuelto.',

    ],

    'requests' => [
        'error'   		=> 'El activo no fue solicitado, por favor, inténtalo de nuevo',
        'success' 		=> 'Activo solicitado correctamente.',
        'canceled'      => 'Solicitud de asignación cancelada con éxito',
    ],

];
