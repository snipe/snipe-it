<?php

return array(

    'accepted'                  => 'Ha aceptado este artículo exitosamente.',
    'declined'                  => 'Ha rechazado este activo con éxito.',
    'bulk_manager_warn'	        => 'Sus usuarios han sido actualizados con éxito, sin embargo, la entrada de administrador no fue guardada porque el gerente seleccionado también estaba en la lista de usuarios a ser editada, y los usuarios no pueden ser sus propios gerentes. Vuelva a seleccionar los usuarios, excluyendo al gerente.',
    'user_exists'               => '¡El usuario ya existe!',
    'user_not_found'            => 'El usuario no existe.',
    'user_login_required'       => 'El campo usuario es obligatorio',
    'user_has_no_assets_assigned' => 'No hay activos asignados al usuario.',
    'user_password_required'    => 'La contraseña es obligatoria.',
    'insufficient_permissions'  => 'Permisos insuficientes.',
    'user_deleted_warning'      => 'Este usuario ha sido eliminado. Tendrá que restaurar este usuario para editarlo o asignarle nuevos recursos.',
    'ldap_not_configured'        => 'La integración LDAP no ha sido configurada para esta instalación.',
    'password_resets_sent'      => 'Los usuarios seleccionados que están activados y tienen una dirección de correo electrónico válida han sido enviados un enlace de restablecimiento de contraseña.',
    'password_reset_sent'       => 'Un enlace para restablecer la contraseña ha sido enviado a :email!',
    'user_has_no_email'         => 'Este usuario no tiene una dirección de correo electrónico en su perfil.',
    'log_record_not_found'        => 'No se pudo encontrar un registro de registro coincidente para este usuario.',


    'success' => array(
        'create'    => 'El usuario se ha creado correctamente.',
        'update'    => 'Usuario actualizado exitosamente.',
        'update_bulk'    => '¡Usuarios actualizados con éxito!',
        'delete'    => 'El usuario se ha eliminado correctamente.',
        'ban'       => 'El usuario fue baneado con éxito.',
        'unban'     => 'El usuario se ha desbaneado correctamente.',
        'suspend'   => 'El usuario fue suspendido correctamente.',
        'unsuspend' => 'El usuario no fue suspendido correctamente.',
        'restored'  => 'Usuario restaurado correctamente.',
        'import'    => 'Usuarios importados con éxito.',
    ),

    'error' => array(
        'create' => 'Hubo un problema al crear el usuario. Por favor, inténtelo de nuevo.',
        'update' => 'Hubo un problema al actualizar el usuario. Por favor, inténtelo de nuevo.',
        'delete' => 'Hubo un problema al eliminar el usuario. Por favor, inténtelo de nuevo.',
        'delete_has_assets' => 'Este usuario tiene elementos asignados y no se ha podido eliminar.',
        'delete_has_assets_var' => 'This user still has an asset assigned. Please check it in first.|This user still has :count assets assigned. Please check their assets in first.',
        'delete_has_licenses_var' => 'This user still has a license seats assigned. Please check it in first.|This user still has :count license seats assigned. Please check them in first.',
        'delete_has_accessories_var' => 'This user still has an accessory assigned. Please check it in first.|This user still has :count accessories assigned. Please check their assets in first.',
        'delete_has_locations_var' => 'This user still manages a location. Please select another manager first.|This user still manages :count locations. Please select another manager first.',
        'delete_has_users_var' => 'This user still manages another user. Please select another manager for that user first.|This user still manages :count users. Please select another manager for them first.',
        'unsuspend' => 'Hubo un problema sin suspender al usuario. Por favor, inténtelo de nuevo.',
        'import'    => 'Hubo un problema importando usuarios. Por favor, inténtelo de nuevo.',
        'asset_already_accepted' => 'Este activo ya ha sido aceptado.',
        'accept_or_decline' => 'Debe aceptar o rechazar este activo.',
        'cannot_delete_yourself' => 'We would feel really bad if you deleted yourself, please reconsider.',
        'incorrect_user_accepted' => 'El elemento que ha intentado aceptar no fue asignado a usted.',
        'ldap_could_not_connect' => 'No se pudo conectar al servidor LDAP. Por favor, compruebe la configuración del servidor LDAP en el archivo de configuración LDAP. <br>Error del servidor LDAP:',
        'ldap_could_not_bind' => 'No se pudo enlazar al servidor LDAP. Por favor, compruebe la configuración del servidor LDAP en el archivo de configuración LDAP. <br>Error del servidor LDAP: ',
        'ldap_could_not_search' => 'No se pudo buscar en el servidor LDAP. Por favor, compruebe la configuración del servidor LDAP en el archivo de configuración LDAP. <br>Error del servidor LDAP:',
        'ldap_could_not_get_entries' => 'No se han podido obtener entradas del servidor LDAP. Por favor, compruebe la configuración del servidor LDAP en el archivo de configuración LDAP. <br>Error del servidor LDAP:',
        'password_ldap' => 'La contraseña de esta cuenta es administrada por LDAP/Active Directory. Póngase en contacto con su departamento de TI para cambiar su contraseña. ',
    ),

    'deletefile' => array(
        'error'   => 'Archivo no eliminado. Vuelve a intentarlo.',
        'success' => 'Archivo eliminado correctamente.',
    ),

    'upload' => array(
        'error'   => 'Archivo(s) no cargados. Por favor, inténtelo de nuevo.',
        'success' => 'Archivo(s) cargados correctamente.',
        'nofiles' => 'No has seleccionado ningún archivo para subir',
        'invalidfiles' => 'Uno o más de sus archivos es demasiado grande o es un tipo de archivo que no está permitido. Los tipos de archivo permitidos son png, gif, jpg, doc, docx, pdf y txt.',
    ),

    'inventorynotification' => array(
        'error'   => 'Este usuario no tiene ningún correo electrónico.',
        'success' => 'El usuario ha sido notificado sobre su inventario actual.'
    )
);