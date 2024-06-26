<?php

return [

    'undeployable' 		=> '<strong>Atención:</strong> Este elemento ha sido marcado como no utilizable.
                        Si no es correcto, actualice el estado.',
    'does_not_exist' 	=> 'Equipo inexistente.',
    'does_not_exist_var'=> 'Activo con etiqueta :asset_tag no encontrado.',
    'no_tag' 	        => 'No se ha proporcionado ninguna etiqueta de activo.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no puede ser solicitado.',
    'assoc_users'	 	=> 'Equipo asignado a un usuario, no se puede eliminar.',
    'warning_audit_date_mismatch' 	=> 'La próxima fecha de auditoría de este activo (:next_audit_date) es anterior a la última fecha de auditoría (:last_audit_date). Por favor, actualice la próxima fecha de auditoría.',

    'create' => [
        'error'   		=> 'El activo no fue creado, por favor, inténtelo de nuevo. :(',
        'success' 		=> 'Equipo creado. :)',
        'success_linked' => 'Activo con etiqueta :tag creado con éxito. <strong><a href=":link" style="color: white;">Haga clic aquí para ver</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Equipo no actualizado, intentalo de nuevo',
        'success' 			=> 'Equipo actualizado.',
        'encrypted_warning' => 'Activo actualizado con éxito, pero los campos personalizados cifrados no se actualizaron debido a permisos',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
        'no_assets_selected'  =>  'Ningún recurso fue seleccionado, por lo que no se actualizó nada.',
        'assets_do_not_exist_or_are_invalid' => 'Los activos seleccionados no se pueden actualizar.',
    ],

    'restore' => [
        'error'   		=> 'El equipo no fue restaurado, por favor intente nuevamente',
        'success' 		=> 'Equipo restaurado correctamente.',
        'bulk_success' 		=> 'Activo restaurado con éxito.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se restauró nada.', 
    ],

    'audit' => [
        'error'   		=> 'Auditoría de activos fallida: :error ',
        'success' 		=> 'Auditoría de activos registrada correctamente.',
    ],


    'deletefile' => [
        'error'   => 'Archivo no eliminado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ],

    'upload' => [
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
        'success' => 'Archivo(s) cargado(s) exitosamente.',
        'nofiles' => 'No seleccionó ningún archivo para ser cargado, o el archivo que está tratando de cargar es demasiado grande',
        'invalidfiles' => 'Uno o más sus archivos es demasiado grande o es de un tipo no permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf y txt.',
    ],

    'import' => [
        'error'                 => 'Algunos elementos no se pudieron importar correctamente.',
        'errorDetail'           => 'Estos elementos no pudieron importarse debido a errores.',
        'success'               => 'Tu archivo ha sido importado',
        'file_delete_success'   => 'Tu archivo ha sido eliminado con éxito',
        'file_delete_error'      => 'No pudimos eliminar tu archivo',
        'file_missing' => 'Falta el archivo seleccionado',
        'header_row_has_malformed_characters' => 'Uno o más atributos de la fila de encabezado contiene caracteres UTF-8 mal formados',
        'content_row_has_malformed_characters' => 'Uno o más atributos de la fila de encabezado contiene caracteres UTF-8 mal formados',
    ],


    'delete' => [
        'confirm'   	=> '¿Está seguro de que desea eliminar este activo?',
        'error'   		=> 'Equipo no eliminado, intentalo de nuevo.',
        'nothing_updated'   => 'No se seleccionaron los activos, por lo que no se eliminó nada.',
        'success' 		=> 'Equipo eliminado.',
    ],

    'checkout' => [
        'error'   		=> 'El activo no fue asignado, por favor inténtelo de nuevo',
        'success' 		=> 'Equipo asignado.',
        'user_does_not_exist' => 'Este usuario no es correcto. Intentalo de nuevo.',
        'not_available' => '¡Ese artículo no está disponible para retirada!',
        'no_assets_selected' => 'Debes seleccionar al menos un elemento de la lista',
    ],

    'checkin' => [
        'error'   		=> 'El equipo no se pudo devolver, por favor inténtelo de nuevo',
        'success' 		=> 'El activo fue devuelto exitosamente.',
        'user_does_not_exist' => 'Es usuario no es correcto, por favor inténtelo de nuevo.',
        'already_checked_in'  => 'El equipo ya ha sido devuelto.',

    ],

    'requests' => [
        'error'   		=> 'Bien no solicitado, por favor inténtelo de nuevo',
        'success' 		=> 'Bien solicitado correctamente.',
        'canceled'      => 'Solicitud de retirada cancelada con éxito',
    ],

];
