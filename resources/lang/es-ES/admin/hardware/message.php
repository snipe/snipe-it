<?php

return [

<<<<<<< HEAD
    'undeployable' 		=> '<strong>Advertencia:</strong> Este activo actualmente está marcado como no utilizable. Si este estado ha cambiado, por favor, actualice el estado del activo.',
    'does_not_exist' 	=> 'El activo no existe.',
    'does_not_exist_var'=> 'Activo con placa :asset_tag no encontrado.',
    'no_tag' 	        => 'No se ha proporcionado ninguna placa de activo.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no puede ser solicitado.',
    'assoc_users'	 	=> 'Actualmente este activo está asignado a un usuario y no puede ser eliminado. Por favor, primero devuelva o recupere el activo y vuelva a intentarlo. ',
    'warning_audit_date_mismatch' 	=> 'La próxima fecha de auditoría de este activo (:next_audit_date) es anterior a la última fecha de auditoría (:last_audit_date). Por favor, actualice la próxima fecha de auditoría.',

    'create' => [
        'error'   		=> 'El activo no fue creado, por favor, inténtelo de nuevo. :(',
        'success' 		=> 'Equipo creado. :)',
        'success_linked' => 'Activo con placa :tag creado con éxito. <strong><a href=":link" style="color: white;">Haga clic aquí para ver</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'El activo no pudo ser actualizado, por favor inténtelo de nuevo',
        'success' 			=> 'Equipo actualizado.',
        'encrypted_warning' => 'El activo se actualizó correctamente, pero los campos personalizados cifrados no lo hicieron debido a los permisos',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
        'no_assets_selected'  =>  'Ningún activo fue seleccionado, por lo que no se actualizó nada.',
        'assets_do_not_exist_or_are_invalid' => 'Los activos seleccionados no se pueden actualizar.',
    ],

    'restore' => [
        'error'   		=> 'El activo no fue restaurado, por favor inténtelo nuevamente',
        'success' 		=> 'Equipo restaurado correctamente.',
        'bulk_success' 		=> 'Equipo restaurado correctamente.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se restauró nada.', 
    ],

    'audit' => [
        'error'   		=> 'Auditoría de activos fallida: :error ',
=======
    'undeployable' 		=> '<strong>Atención: </strong> Este equipo está marcado como no isntalabre.
                        Si no es correcto, actualiza su estado.',
    'does_not_exist' 	=> 'Equipo inexistente.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Equipo asignado a un usuario, no se puede eliminar.',

    'create' => [
        'error'   		=> 'Equipo no creado, intentalo de nuevo. :(',
        'success' 		=> 'Equipo creado. :)',
    ],

    'update' => [
        'error'   			=> 'Equipo no actualizado, intentalo de nuevo',
        'success' 			=> 'Equipo actualizado.',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
    ],

    'restore' => [
        'error'   		=> 'El equipo no fue restaurado, por favor intente nuevamente',
        'success' 		=> 'Equipo restaurado correctamente.',
    ],

    'audit' => [
        'error'   		=> 'La auditoría de activos no tuvo éxito. Vuelve a intentarlo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' 		=> 'Auditoría de activos registrada correctamente.',
    ],


    'deletefile' => [
<<<<<<< HEAD
        'error'   => 'Archivo no eliminado. Por favor inténtelo nuevamente.',
=======
        'error'   => 'Archivo no eliminado. Por favor, vuelva a intentarlo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'Archivo eliminado correctamente.',
    ],

    'upload' => [
<<<<<<< HEAD
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
        'success' => 'Archivo(s) cargado(s) exitosamente.',
        'nofiles' => 'No seleccionó ningún archivo para ser cargado, o el archivo que está tratando de cargar es demasiado grande',
        'invalidfiles' => 'Uno o más de sus archivos son demasiado grandes o son de un tipo de archivo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf y txt.',
    ],

    'import' => [
        'import_button'         => 'Proceso para importar',
        'error'                 => 'Algunos elementos no se pudieron importar correctamente.',
        'errorDetail'           => 'Estos elementos no pudieron importarse debido a errores.',
        'success'               => 'Su archivo ha sido importado',
        'file_delete_success'   => 'Su archivo se ha eliminado correctamente',
        'file_delete_error'      => 'No pudimos eliminar tu archivo',
        'file_missing' => 'Falta el archivo seleccionado',
        'header_row_has_malformed_characters' => 'Uno o más atributos en la fila del encabezado contienen caracteres UTF-8 mal formados',
        'content_row_has_malformed_characters' => 'Uno o más atributos en la primera fila de contenido contienen caracteres UTF-8 mal formados',
=======
        'error'   => 'Archivo(s) no cargado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo(s) cargado correctamente.',
        'nofiles' => 'No ha seleccionado ningun archivo para ser cargado, o el archivo que seleccionó es demasiado grande',
        'invalidfiles' => 'Uno o más sus archivos es demasiado grande o es de un tipo no permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf y txt.',
    ],

    'import' => [
        'error'                 => 'Algunos elementos no se pudieron importar correctamente.',
        'errorDetail'           => 'Estos elementos no pudieron importarse debido a errores.',
        'success'               => 'Tu archivo ha sido importado',
        'file_delete_success'   => 'Tu archivo ha sido eliminado con éxito',
        'file_delete_error'      => 'No pudimos eliminar tu archivo',
>>>>>>> 64747d0fb (updates based on review)
    ],


    'delete' => [
<<<<<<< HEAD
        'confirm'   	=> '¿Está seguro de que desea eliminar este activo?',
        'error'   		=> 'Hubo un problema al eliminar el activo. Por favor, inténtelo de nuevo.',
=======
        'confirm'   	=> 'Estás seguro que quieres eliminar el equipo?',
        'error'   		=> 'Equipo no eliminado, intentalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'nothing_updated'   => 'No se seleccionaron los activos, por lo que no se eliminó nada.',
        'success' 		=> 'Equipo eliminado.',
    ],

    'checkout' => [
<<<<<<< HEAD
        'error'   		=> 'El activo no fue asignado, por favor inténtelo de nuevo',
        'success' 		=> 'Equipo asignado correctamente.',
        'user_does_not_exist' => 'Este usuario no es correcto. Por favor, inténtelo de nuevo.',
        'not_available' => '¡Ese equipo no está disponible para ser asignado!',
=======
        'error'   		=> 'Equipo no asignado, intentalo de nuevo',
        'success' 		=> 'Equipo asignado.',
        'user_does_not_exist' => 'Este usuario no es correcto. Intentalo de nuevo.',
        'not_available' => '¡Ese artículo no está disponible para retirada!',
>>>>>>> 64747d0fb (updates based on review)
        'no_assets_selected' => 'Debes seleccionar al menos un elemento de la lista',
    ],

    'checkin' => [
<<<<<<< HEAD
        'error'   		=> 'El activo no se pudo ingresar, por favor inténtelo de nuevo',
        'success' 		=> 'El activo fue ingresado exitosamente.',
        'user_does_not_exist' => 'Este usuario no es correcto. Por favor, inténtelo de nuevo.',
        'already_checked_in'  => 'El equipo ya ha sido recibido.',
=======
        'error'   		=> 'No se ha quitado el equipo. Intentalo de nuevo.',
        'success' 		=> 'Equipo quitado correctamente.',
        'user_does_not_exist' => 'Este usuario no es correcto. Intentalo de nuevo.',
        'already_checked_in'  => 'Ese activo ya se quito.',
>>>>>>> 64747d0fb (updates based on review)

    ],

    'requests' => [
<<<<<<< HEAD
        'error'   		=> 'El activo no pudo ser solicitado, por favor inténtelo de nuevo',
        'success' 		=> 'Activo solicitado correctamente.',
        'canceled'      => 'La solicitud de asignación fue cancelada de forma exitosa',
=======
        'error'   		=> 'Bien no solicitado, por favor inténtelo de nuevo',
        'success' 		=> 'Bien solicitado correctamente.',
        'canceled'      => 'Solicitud de retirada cancelada con éxito',
>>>>>>> 64747d0fb (updates based on review)
    ],

];
