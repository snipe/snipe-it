<?php

return array(

    'accepted'                  => 'Ha aceptado con éxito este equipo.',
    'declined'                  => 'Ha declinado con éxito este equipo.',
    'bulk_manager_warn'	        => 'Sus usuarios han sido correctamente actualizados, de todos modos la entrada de administrador no fue guardada porque el administrador seleccionado también estaba en la lista de usuarios a ser editada, y los usuarios no pueden ser sus propior administradores. Vuelva a seleccionar los usuarios, excluyendo al administrador.',
    'user_exists'               => 'El Usuario ya existe!',
    'user_not_found'            => 'Usuario [:id] no existe.',
    'user_login_required'       => 'El campo Usuario es obligatorio',
    'user_password_required'    => 'El password es obligatorio.',
    'insufficient_permissions'  => 'No tiene permiso.',
    'user_deleted_warning'      => 'Este usuario ha sido eliminado. Deberá restaurarlo para editarlo o asignarle nuevos Equipos.',
    'ldap_not_configured'        => 'La integración con LDAP no ha sido configurada para esta instalación.',


    'success' => array(
        'create'    => 'Usuario correctamente creado.',
        'update'    => 'Usuario correctamente actualizado.',
        'update_bulk'    => 'Usuarios correctamente actualizados!',
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
        'delete_has_assets' => 'Este usuario tiene elementos asignados y no se pueden eliminar.',
        'unsuspend' => 'Ha habido un problema marcando como no suspendido el Usuario. Intentalo de nuevo.',
        'import'    => 'Ha habido un problema importando los usuarios. Por favor intente nuevamente.',
        'asset_already_accepted' => 'Este equipo ya ha sido aceptado.',
        'accept_or_decline' => 'Debe aceptar o declinar este equipo.',
        'incorrect_user_accepted' => 'El equipo que has permitido aceptar no te tiene checkeado a ti.',
        'ldap_could_not_connect' => 'No se ha podido conectar con el servidor LDAP. Por favor verifique la configuración de su servidor LDAP en su archivo de configuración.<br> Error del servidor LDAP:',
        'ldap_could_not_bind' => 'No se ha podido vincular con el servidor LDAP. Por favor verifique la configuración de su servidor LDAP en su archivo de configuración.<br> Error del servidor LDAP: ',
        'ldap_could_not_search' => 'No se ha podido buscar en el servidor LDAP. Por favor verifique la configuración de su servidor LDAP en su archivo de configuración.<br> Error del servidor LDAP:',
        'ldap_could_not_get_entries' => 'No se han podido obtener entradas del servidor LDAP. Por favor verifique la configuración de su servidor LDAP en su archivo de configuración.<br> Error del servidor LDAP:',
        'password_ldap' => 'La contraseña para esta cuenta es administrada por LDAP / Active Directory. Póngase en contacto con su departamento de TI para cambiar su contraseña.',
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
