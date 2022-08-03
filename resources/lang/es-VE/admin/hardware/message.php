<?php

return [

<<<<<<< HEAD
    'undeployable' 		=> '<strong>Advertencia:</strong> Este activo actualmente está marcado como no utilizable. Si este estado ha cambiado, por favor, actualice el estado del activo.',
    'does_not_exist' 	=> 'El activo no existe.',
    'does_not_exist_var'=> 'Activo con placa :asset_tag no encontrado.',
    'no_tag' 	        => 'No se ha proporcionado ninguna placa de activo.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no es solicitable.',
    'assoc_users'	 	=> 'Actualmente este activo está asignado a un usuario y no puede ser eliminado. Por favor, primero devuelva o recupere el activo y vuelva a intentarlo. ',
    'warning_audit_date_mismatch' 	=> 'La próxima fecha de auditoría de este activo (:next_audit_date) es anterior a la última fecha de auditoría (:last_audit_date). Por favor, actualice la próxima fecha de auditoría.',

    'create' => [
        'error'   		=> 'El activo no fue creado, por favor, inténtelo de nuevo. :(',
        'success' 		=> 'Activo creado con éxito. :)',
        'success_linked' => 'Activo con placa :tag creado con éxito. <strong><a href=":link" style="color: white;">Haga clic aquí para ver</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'El activo no pudo ser actualizado, por favor inténtelo de nuevo',
        'success' 			=> 'Activo actualizado con éxito.',
        'encrypted_warning' => 'El activo se actualizó correctamente, pero los campos personalizados cifrados no lo hicieron debido a los permisos',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, así que nada se actualizó.',
        'no_assets_selected'  =>  'Ningún activo fue seleccionado, por lo que no se actualizó nada.',
        'assets_do_not_exist_or_are_invalid' => 'Los activos seleccionados no se pueden actualizar.',
    ],

    'restore' => [
        'error'   		=> 'El activo no fue restaurado, por favor inténtelo nuevamente',
        'success' 		=> 'Activo restaurado correctamente.',
        'bulk_success' 		=> 'Activo restaurado correctamente.',
        'nothing_updated'   => 'No se seleccionaron activos, por lo que no se restauró nada.', 
    ],

    'audit' => [
        'error'   		=> 'Auditoría de activos fallida: :error ',
=======
    'undeployable' 		=> '<strong>Advertencia:</strong> este activo ha sido marcado actualmente como no enviable.                         Si este estado cambia, por favor actualiza el estado de activos.',
    'does_not_exist' 	=> 'El activo no existe.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Este activo está actualmente asignado a un usuario y no puede ser borrado. Por favor, revisa el activo primero y luego intenta borrarlo. ',

    'create' => [
        'error'   		=> 'El activo no ha sido creado, por favor, inténtelo de nuevo. :(',
        'success' 		=> 'Activo creado con éxito. :)',
    ],

    'update' => [
        'error'   			=> 'Activo no ha sido actualizado, por favor, inténtelo de nuevo',
        'success' 			=> 'Activo actualizado con éxito.',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, así que nada se actualizó.',
    ],

    'restore' => [
        'error'   		=> 'El activo no fue restaurado, por favor, inténtalo de nuevo',
        'success' 		=> 'Activo restaurado correctamente.',
    ],

    'audit' => [
        'error'   		=> 'La auditoria de activo no tuvo éxito. Inténtalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' 		=> 'Audoría de activo registrada con éxito.',
    ],


    'deletefile' => [
<<<<<<< HEAD
        'error'   => 'Archivo no eliminado. Por favor inténtelo nuevamente.',
=======
        'error'   => 'El archivo no fue borrado. Por favor, inténtalo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'success' => 'Archivo borrado con éxito.',
    ],

    'upload' => [
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
<<<<<<< HEAD
        'success' => 'Archivo(s) cargado(s) exitosamente.',
        'nofiles' => 'No seleccionó ningún archivo para ser cargado, o el archivo que está tratando de cargar es demasiado grande',
        'invalidfiles' => 'Uno o más de sus archivos son demasiado grandes o son de un tipo de archivo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf y txt.',
    ],

    'import' => [
        'import_button'         => 'Proceso para importar',
        'error'                 => 'Algunos de los elementos no se importaron correctamente.',
        'errorDetail'           => 'Lo siguientes elementos no se importaron debido a errores.',
        'success'               => 'Su archivo ha sido importado',
        'file_delete_success'   => 'Su archivo se ha eliminado correctamente',
        'file_delete_error'      => 'El archivo no se pudo eliminar',
        'file_missing' => 'Falta el archivo seleccionado',
        'header_row_has_malformed_characters' => 'Uno o más atributos en la fila del encabezado contienen caracteres UTF-8 mal formados',
        'content_row_has_malformed_characters' => 'Uno o más atributos en la primera fila de contenido contienen caracteres UTF-8 mal formados',
=======
        'success' => 'Archivo(s) cargado(s) con éxito.',
        'nofiles' => 'No seleccionaste ningún archivo para actualizar, o el archivo que estás intentando cargar es demasiado grande',
        'invalidfiles' => 'Uno o más de tus archivos es demasiado grande o es de un tipo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf, y txt.',
    ],

    'import' => [
        'error'                 => 'Algunos de los elementos no se importaron correctamente.',
        'errorDetail'           => 'Lo siguientes elementos no se importaron debido a errores.',
        'success'               => 'Tu archivo ha sido importado',
        'file_delete_success'   => 'Tu archivo ha sido eliminado con éxito',
        'file_delete_error'      => 'El archivo no se pudo eliminar',
>>>>>>> 64747d0fb (updates based on review)
    ],


    'delete' => [
<<<<<<< HEAD
        'confirm'   	=> '¿Está seguro de que desea eliminar este activo?',
        'error'   		=> 'Hubo un problema al eliminar el activo. Por favor, inténtelo de nuevo.',
=======
        'confirm'   	=> '¿Estás seguro de que quieres borrar este archivo?',
        'error'   		=> 'Ha habido un problema eliminando el activo. Por favor, inténtelo de nuevo.',
>>>>>>> 64747d0fb (updates based on review)
        'nothing_updated'   => 'Ningún activo se seleccionó, así que nada fue borrado.',
        'success' 		=> 'El activo fue borrado con éxito.',
    ],

    'checkout' => [
<<<<<<< HEAD
        'error'   		=> 'El activo no fue asignado, por favor inténtelo de nuevo',
        'success' 		=> 'Equipo asignado correctamente.',
        'user_does_not_exist' => 'Este usuario no es correcto. Por favor, inténtelo de nuevo.',
        'not_available' => '¡Ese equipo no está disponible para ser asignado!',
=======
        'error'   		=> 'El activo no se ha asignado, por favor, inténtelo de nuevo',
        'success' 		=> 'Activo asignado con éxito.',
        'user_does_not_exist' => 'El usuario es inválido. Por favor, inténtelo de nuevo.',
        'not_available' => '¡Ese activo no está disponible para retirar!',
>>>>>>> 64747d0fb (updates based on review)
        'no_assets_selected' => 'Debes seleccionar al menos un activo de la lista',
    ],

    'checkin' => [
<<<<<<< HEAD
        'error'   		=> 'El activo no se pudo ingresar, por favor inténtelo de nuevo',
        'success' 		=> 'El activo fue ingresado exitosamente.',
        'user_does_not_exist' => 'Este usuario no es correcto. Por favor, inténtelo de nuevo.',
        'already_checked_in'  => 'El equipo ya ha sido recibido.',
=======
        'error'   		=> 'El activo no se ha registrado, por favor, inténtelo de nuevo',
        'success' 		=> 'Activo registrado con éxito.',
        'user_does_not_exist' => 'El usuario es inválido. Por favor inténtelo de nuevo.',
        'already_checked_in'  => 'Ese activo ya ha sido registrado.',
>>>>>>> 64747d0fb (updates based on review)

    ],

    'requests' => [
<<<<<<< HEAD
        'error'   		=> 'El activo no pudo ser solicitado, por favor inténtelo de nuevo',
        'success' 		=> 'Activo solicitado correctamente.',
        'canceled'      => 'La solicitud de asignación fue cancelada de forma exitosa',
=======
        'error'   		=> 'El activo no fue solicitado, por favor, inténtalo de nuevo',
        'success' 		=> 'Activo solicitado correctamente.',
        'canceled'      => 'Solicitud de asignación cancelada con éxito',
>>>>>>> 64747d0fb (updates based on review)
    ],

];
