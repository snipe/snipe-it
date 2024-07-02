<?php

return array(

    'accepted'                  => 'Ha aceptado este artículo exitosamente.',
    'declined'                  => 'Has rechazado este activo con éxito.',
    'bulk_manager_warn'	        => 'Sus usuarios han sido actualizados con éxito, sin embargo, la entrada de administrador no fue guardada porque el gerente seleccionado también estaba en la lista de usuarios a ser editada, y los usuarios no pueden ser sus propios gerentes. Vuelva a seleccionar los usuarios, excluyendo al gerente.',
    'user_exists'               => '¡El usuario ya existe!',
    'user_not_found'            => 'El usuario no existe.',
    'user_login_required'       => 'El campo usuario es obligatorio',
    'user_has_no_assets_assigned' => 'No hay activos asignados al usuario.',
    'user_password_required'    => 'La contraseña es obligatoria.',
    'insufficient_permissions'  => 'Permisos insuficientes.',
    'user_deleted_warning'      => 'Este usuario ha sido eliminado. Tendrá que restaurar este usuario para editarlo o para asignarle nuevos activos.',
    'ldap_not_configured'        => 'La integración LDAP no ha sido configurada para esta instalación.',
    'password_resets_sent'      => 'Los usuarios seleccionados que están activados y tienen una dirección de correo electrónico válida han sido enviados un enlace de restablecimiento de contraseña.',
    'password_reset_sent'       => 'Un enlace para restablecer la contraseña ha sido enviado a :email!',
    'user_has_no_email'         => 'Este usuario no tiene una dirección de correo electrónico en su perfil.',
    'log_record_not_found'        => 'No se pudo encontrar un registro de registro coincidente para este usuario.',


    'success' => array(
        'create'    => 'El usuario fue creado con éxito.',
        'update'    => 'Usuario actualizado exitosamente.',
        'update_bulk'    => '¡Los usuarios fueron actualizados con éxito!',
        'delete'    => 'Usuario borrado con éxito.',
        'ban'       => 'Usuario bloqueado con éxito.',
        'unban'     => 'Usuario desbloqueado con éxito.',
        'suspend'   => 'Usuario suspendido con éxito.',
        'unsuspend' => 'Usuario des-suspendido con éxito.',
        'restored'  => 'Usuario restaurado con éxito.',
        'import'    => 'Usuarios importados con éxito.',
    ),

    'error' => array(
        'create' => 'Hubo un problema creando el usuario. Por favor, inténtalo de nuevo.',
        'update' => 'Hubo un problema actualizando al usuario. Por favor, inténtalo de nuevo.',
        'delete' => 'Hubo un problema borrando el usuario. Por favor, inténtalo de nuevo.',
        'delete_has_assets' => 'Este usuario tiene elementos asignados y no pudo ser borrado.',
        'delete_has_assets_var' => 'Este usuario todavía tienen un activo asignado. Por favor devuélvalo primero.| Este usuario todavía tienen :count activos asignados. Por favor devuélvalos primero.',
        'delete_has_licenses_var' => 'Este usuario todavía tiene una licencia asignada. Por favor primero haga su devolución.|Este usuario todavía tiene :count licencias asignadas. Por favor primero haga su devolución.',
        'delete_has_accessories_var' => 'Este usuario todavía tiene un accesorio asignado. Por favor primero haga su devolución.|Este usuario todavía tiene :count accesorios asignados. Por favor primero haga su devolución.',
        'delete_has_locations_var' => 'Este usuario todavía supervisa una ubicación. Por favor seleccione otro supervisor primero.|Este usuario todavía supervisa :count ubicaciones. Por favor seleccione otro supervisor primero.',
        'delete_has_users_var' => 'Este usuario todavía supervisa a otro usuario. Por favor primero seleccione otro supervisor para ese usuario.|Este usuario todavía supervisa :count usuarios. Por favor primero seleccione otro supervisor para ellos.',
        'unsuspend' => 'Hubo un problema des-suspendiendo al usuario. Por favor inténtelo de nuevo.',
        'import'    => 'Hubo un problema importando usuarios. Por favor inténtelo de nuevo.',
        'asset_already_accepted' => 'Este activo ya ha sido aceptado.',
        'accept_or_decline' => 'Debes aceptar o rechazar este activo.',
        'cannot_delete_yourself' => 'Nos sentiríamos muy mal si usted se eliminara, por favor reconsidérelo.',
        'incorrect_user_accepted' => 'El elemento que ha intentado aceptar no fue asignado a usted.',
        'ldap_could_not_connect' => 'No se pudo conectar al servidor LDAP. Por favor verifica la configuración LDAP de tu servidor en el archivo de configuración LDAP. <br>Error del servidor LDAP:',
        'ldap_could_not_bind' => 'No se pudo enlazar al servidor LDAP. Por favor verifica la configuración LDAP de tu servidor en el archivo de configuración LDAP. <br>Error del servidor LDAP: ',
        'ldap_could_not_search' => 'No se pudo buscar el servidor LDAP. Por favor verifica la configuración LDAP de tu servidor en el archivo de configuración LDAP. <br>Error del servidor LDAP:',
        'ldap_could_not_get_entries' => 'No se pudieron obtener las entradas del servidor LDAP. Por favor verifica la configuración LDAP de tu servidor en el archivo de configuración LDAP. <br>Error del servidor LDAP:',
        'password_ldap' => 'La contraseña para esta cuenta es manejada por LDAP/Active Directory. Por favor contacta a tu departamento de IT para cambiar tu contraseña. ',
    ),

    'deletefile' => array(
        'error'   => 'El archivo no fue borrado. Por favor, inténtalo de nuevo.',
        'success' => 'Archivo borrado con éxito.',
    ),

    'upload' => array(
        'error'   => 'Archivo(s) no cargado(s). Por favor, inténtelo nuevamente.',
        'success' => 'Archivo(s) cargado(s) con éxito.',
        'nofiles' => 'No ha seleccionado ningún archivo para subir',
        'invalidfiles' => 'Uno o más de tus archivos es demasiado grande o es de un tipo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf, y txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'Este usuario no tiene ningún correo electrónico.',
        'success' => 'El usuario ha sido notificado sobre su inventario actual.'
    )
);