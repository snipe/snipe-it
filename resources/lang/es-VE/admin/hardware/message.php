<?php

return [

    'undeployable' 		=> '<strong>Advertencia:</strong> este activo ha sido marcado actualmente como no enviable.                         Si este estado cambia, por favor actualiza el estado de activos.',
    'does_not_exist' 	=> 'El activo no existe.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no es solicitable.',
    'assoc_users'	 	=> 'Este activo está actualmente asignado a un usuario y no puede ser borrado. Por favor, revisa el activo primero y luego intenta borrarlo. ',

    'create' => [
        'error'   		=> 'El activo no ha sido creado, por favor, inténtelo de nuevo. :(',
        'success' 		=> 'Activo creado con éxito. :)',
    ],

    'update' => [
        'error'   			=> 'Activo no ha sido actualizado, por favor, inténtelo de nuevo',
        'success' 			=> 'Activo actualizado con éxito.',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, así que nada se actualizó.',
        'no_assets_selected'  =>  'Ningún recurso fue seleccionado, por lo que no se actualizó nada.',
    ],

    'restore' => [
        'error'   		=> 'El activo no fue restaurado, por favor, inténtalo de nuevo',
        'success' 		=> 'Activo restaurado correctamente.',
    ],

    'audit' => [
        'error'   		=> 'La auditoria de activo no tuvo éxito. Inténtalo de nuevo.',
        'success' 		=> 'Audoría de activo registrada con éxito.',
    ],


    'deletefile' => [
        'error'   => 'El archivo no fue borrado. Por favor, inténtalo de nuevo.',
        'success' => 'Archivo borrado con éxito.',
    ],

    'upload' => [
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
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
    ],


    'delete' => [
        'confirm'   	=> '¿Estás seguro de que quieres borrar este archivo?',
        'error'   		=> 'Ha habido un problema eliminando el activo. Por favor, inténtelo de nuevo.',
        'nothing_updated'   => 'Ningún activo se seleccionó, así que nada fue borrado.',
        'success' 		=> 'El activo fue borrado con éxito.',
    ],

    'checkout' => [
        'error'   		=> 'El activo no se ha asignado, por favor, inténtelo de nuevo',
        'success' 		=> 'Activo asignado con éxito.',
        'user_does_not_exist' => 'El usuario es inválido. Por favor, inténtelo de nuevo.',
        'not_available' => '¡Ese activo no está disponible para retirar!',
        'no_assets_selected' => 'Debes seleccionar al menos un activo de la lista',
    ],

    'checkin' => [
        'error'   		=> 'El activo no se ha registrado, por favor, inténtelo de nuevo',
        'success' 		=> 'Activo registrado con éxito.',
        'user_does_not_exist' => 'El usuario es inválido. Por favor inténtelo de nuevo.',
        'already_checked_in'  => 'Ese activo ya ha sido registrado.',

    ],

    'requests' => [
        'error'   		=> 'El activo no fue solicitado, por favor, inténtalo de nuevo',
        'success' 		=> 'Activo solicitado correctamente.',
        'canceled'      => 'Solicitud de asignación cancelada con éxito',
    ],

];
