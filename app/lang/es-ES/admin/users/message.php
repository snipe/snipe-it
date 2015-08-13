<?php

return array(

    'accepted'                  => 'Ha aceptado con éxito este equipo.',
    'declined'                  => 'Ha declinado con éxito este equipo.',
    'user_exists'               => 'El Usuario ya existe!',
    'user_not_found'            => 'Usuario [:id] no existe.',
    'user_login_required'       => 'El campo Usuario es obligatorio',
    'user_password_required'    => 'El password es obligatorio.',
    'insufficient_permissions'  => 'No tiene permiso.',
    'user_deleted_warning'      => 'Este usuario ha sido eliminado. Deberá restaurarlo para editarlo o asignarle nuevos Equipos.',


    'success' => array(
        'create'    => 'Usuario correctamente creado.',
        'update'    => 'Usuario correctamente actualizado.',
        'delete'    => 'Usuario correctamente eliminado.',
        'ban'       => 'Usuario correctamente bloqueado.',
        'unban'     => 'Usuario correctamente desbloqueado.',
        'suspend'   => 'Usuario correctamente suspendido.',
        'unsuspend' => 'Usuario correctamente no suspendido.',
        'restored'  => 'Usuario correctamente restaurado.',
        'import'    => 'Usuarios importados correctamente.',
    ),

    'error' => array(
        'create' => 'Ha habido un problema creando el Usuario. Intentalo de nuevo.',
        'update' => 'Ha habido un problema actualizando el Usuario. Intentalo de nuevo.',
        'delete' => 'Ha habido un problema eliminando el  Usuario. Intentalo de nuevo.',
        'unsuspend' => 'Ha habido un problema marcando como no suspendido el Usuario. Intentalo de nuevo.',
        'import'    => 'Ha habido un problema importando los usuarios. Por favor intente nuevamente.',
        'asset_already_accepted' => 'Este equipo ya ha sido aceptado.',
        'accept_or_decline' => 'Debe aceptar o declinar este equipo.',
    ),

    'deletefile' => array(
        'error'   => 'Archivo no eliminado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ),

    'upload' => array(
        'error'   => 'Archivo(s) no cargado. Por favor, vuelva a intentarlo.',
        'success' => 'Archivo(s) cargado correctamente.',
        'nofiles' => 'No ha seleccionado ningún archivo para subir',
        'invalidfiles' => 'Uno o más sus archivos es demasiado grande o es de un tipo no permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf y txt.',
    ),

);
