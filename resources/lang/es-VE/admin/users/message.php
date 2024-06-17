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
    'user_deleted_warning'      => 'Este usuario ha sido eliminado. Deberás restaurar este usuario para editarlo o asignarle nuevos activos.',
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
        'delete_has_assets_var' => 'This user still has an asset assigned. Please check it in first.|This user still has :count assets assigned. Please check their assets in first.',
        'delete_has_licenses_var' => 'This user still has a license seats assigned. Please check it in first.|This user still has :count license seats assigned. Please check them in first.',
        'delete_has_accessories_var' => 'This user still has an accessory assigned. Please check it in first.|This user still has :count accessories assigned. Please check their assets in first.',
        'delete_has_locations_var' => 'This user still manages a location. Please select another manager first.|This user still manages :count locations. Please select another manager first.',
        'delete_has_users_var' => 'This user still manages another user. Please select another manager for that user first.|This user still manages :count users. Please select another manager for them first.',
        'unsuspend' => 'Hubo un problema des-suspendiendo al usuario. Por favor inténtelo de nuevo.',
        'import'    => 'Hubo un problema importando usuarios. Por favor inténtelo de nuevo.',
        'asset_already_accepted' => 'Este activo ya ha sido aceptado.',
        'accept_or_decline' => 'Debes aceptar o rechazar este activo.',
        'cannot_delete_yourself' => 'We would feel really bad if you deleted yourself, please reconsider.',
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