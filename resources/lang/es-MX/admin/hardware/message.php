<?php

return [

    'undeployable' 		=> '<strong>Atención: </strong> Este equipo está marcado como no isntalabre.
                        Si no es correcto, actualiza su estado.',
    'does_not_exist' 	=> 'Equipo inexistente.',
    'does_not_exist_or_not_requestable' => 'Ese activo no existe o no puede ser solicitado.',
    'assoc_users'	 	=> 'Equipo asignado a un usuario, no se puede eliminar.',

    'create' => [
        'error'   		=> 'Equipo no creado, intentalo de nuevo. :(',
        'success' 		=> 'Equipo creado. :)',
    ],

    'update' => [
        'error'   			=> 'Equipo no actualizado, intentalo de nuevo',
        'success' 			=> 'Equipo actualizado.',
        'nothing_updated'	=>  'Ningún campo fue seleccionado, por lo que nada ha sido actualizado.',
        'no_assets_selected'  =>  'Ningún recurso fue seleccionado, por lo que no se actualizó nada.',
    ],

    'restore' => [
        'error'   		=> 'El equipo no fue restaurado, por favor intente nuevamente',
        'success' 		=> 'Equipo restaurado correctamente.',
    ],

    'audit' => [
        'error'   		=> 'La auditoría de activos no tuvo éxito. Vuelve a intentarlo.',
        'success' 		=> 'Auditoría de activos registrada correctamente.',
    ],


    'deletefile' => [
        'error'   => 'Archivo no eliminado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ],

    'upload' => [
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
    ],


    'delete' => [
        'confirm'   	=> 'Estás seguro que quieres eliminar el equipo?',
        'error'   		=> 'Equipo no eliminado, intentalo de nuevo.',
        'nothing_updated'   => 'No se seleccionaron los activos, por lo que no se eliminó nada.',
        'success' 		=> 'Equipo eliminado.',
    ],

    'checkout' => [
        'error'   		=> 'Equipo no asignado, intentalo de nuevo',
        'success' 		=> 'Equipo asignado.',
        'user_does_not_exist' => 'Este usuario no es correcto. Intentalo de nuevo.',
        'not_available' => '¡Ese artículo no está disponible para retirada!',
        'no_assets_selected' => 'Debes seleccionar al menos un elemento de la lista',
    ],

    'checkin' => [
        'error'   		=> 'No se ha quitado el equipo. Intentalo de nuevo.',
        'success' 		=> 'Equipo quitado correctamente.',
        'user_does_not_exist' => 'Este usuario no es correcto. Intentalo de nuevo.',
        'already_checked_in'  => 'Ese activo ya se quito.',

    ],

    'requests' => [
        'error'   		=> 'Bien no solicitado, por favor inténtelo de nuevo',
        'success' 		=> 'Bien solicitado correctamente.',
        'canceled'      => 'Solicitud de retirada cancelada con éxito',
    ],

];
