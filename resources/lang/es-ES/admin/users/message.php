<?php

return array(

    'accepted'                  => 'Ha aceptado este artículo exitosamente.',
    'declined'                  => 'Ha declinado con éxito este equipo.',
    'bulk_manager_warn'	        => 'Sus usuarios han sido actualizados con éxito, sin embargo, la entrada de administrador no fue guardada porque el gerente seleccionado también estaba en la lista de usuarios a ser editada, y los usuarios no pueden ser sus propios gerentes. Vuelva a seleccionar los usuarios, excluyendo al gerente.',
    'user_exists'               => 'El Usuario ya existe!',
    'user_not_found'            => 'Usuario inexistente.',
    'user_login_required'       => 'El campo usuario es obligatorio',
    'user_has_no_assets_assigned' => 'No hay activos asignados al usuario.',
    'user_password_required'    => 'La contraseña es obligatoria.',
    'insufficient_permissions'  => 'No tiene permiso.',
    'user_deleted_warning'      => 'Este usuario ha sido eliminado. Deberá restaurarlo para editarlo o asignarle nuevos Equipos.',
    'ldap_not_configured'        => 'La integración con LDAP no ha sido configurada para esta instalación.',
    'password_resets_sent'      => 'A los usuarios seleccionados que están activados y tienen una dirección de correo electrónico válida se les ha enviado un enlace de restablecimiento de contraseña.',
    'password_reset_sent'       => '¡Se ha enviado un enlace de restablecimiento de contraseña a :email!',
    'user_has_no_email'         => 'Este usuario no tiene una dirección de correo electrónico en su perfil.',
    'log_record_not_found'        => 'No se pudo encontrar un registro de registro coincidente para este usuario.',


    'success' => array(
        'create'    => 'Usuario correctamente creado.',
        'update'    => 'Usuario actualizado exitosamente.',
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
        'delete_has_assets_var' => 'This user still has an asset assigned. Please check it in first.|This user still has :count assets assigned. Please check their assets in first.',
        'delete_has_licenses_var' => 'This user still has a license seats assigned. Please check it in first.|This user still has :count license seats assigned. Please check them in first.',
        'delete_has_accessories_var' => 'This user still has an accessory assigned. Please check it in first.|This user still has :count accessories assigned. Please check their assets in first.',
        'delete_has_locations_var' => 'This user still manages a location. Please select another manager first.|This user still manages :count locations. Please select another manager first.',
        'delete_has_users_var' => 'This user still manages another user. Please select another manager for that user first.|This user still manages :count users. Please select another manager for them first.',
        'unsuspend' => 'Ha habido un problema marcando como no suspendido el Usuario. Intentalo de nuevo.',
        'import'    => 'Ha habido un problema importando los usuarios. Por favor intente nuevamente.',
        'asset_already_accepted' => 'Este equipo ya ha sido aceptado.',
        'accept_or_decline' => 'Debe aceptar o rechazar este equipo.',
        'cannot_delete_yourself' => 'We would feel really bad if you deleted yourself, please reconsider.',
        'incorrect_user_accepted' => 'El elemento que ha intentado aceptar no fue asignado a usted.',
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

    'inventorynotification' => array(
        'error'   => 'Este usuario no tiene ningún correo electrónico.',
        'success' => 'El usuario ha sido notificado sobre su inventario actual.'
    )
);