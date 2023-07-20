<?php

return array(

    'accepted'                  => 'Has aceptado este activo con éxito.',
    'declined'                  => 'Has rechazado este activo con éxito.',
    'bulk_manager_warn'	        => 'Tus usuarios han sido actualizados con éxito, sin embargo tu entrada de administrador no fue guardada debido que el administrador que seleccionaste también era un usuario de la lista que iba a ser editada, y los usuarios no pueden editar a su propio administrador. Por favor selecciona a tus usuarios de nuevo, excluyendo al administrador.',
    'user_exists'               => '¡El usuario ya existe!',
    'user_not_found'            => 'User does not exist.',
    'user_login_required'       => 'El campo de usuario es obligatorio',
    'user_password_required'    => 'La contraseña es obligatoria.',
    'insufficient_permissions'  => 'Permisos insuficientes.',
    'user_deleted_warning'      => 'Este usuario ha sido eliminado. Deberás restaurar este usuario para editarlo o asignarle nuevos activos.',
    'ldap_not_configured'        => 'La integración LDAP no ha sido configurada para esta instalación.',
    'password_resets_sent'      => 'A los usuarios seleccionados que están activados y tienen una dirección de correo electrónico válida se les ha enviado un enlace de restablecimiento de contraseña.',
    'password_reset_sent'       => '¡Se ha enviado un enlace de restablecimiento de contraseña a :email!',
    'user_has_no_email'         => 'Este usuario no tiene una dirección de correo electrónico en su perfil.',
    'user_has_no_assets_assigned'   => 'Este usuario no tiene ningún activo asignado',


    'success' => array(
        'create'    => 'El usuario fue creado con éxito.',
        'update'    => 'El usuario fue actualizado con éxito.',
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
        'unsuspend' => 'Hubo un problema des-suspendiendo al usuario. Por favor inténtelo de nuevo.',
        'import'    => 'Hubo un problema importando usuarios. Por favor inténtelo de nuevo.',
        'asset_already_accepted' => 'Este activo ya ha sido aceptado.',
        'accept_or_decline' => 'Debes aceptar o rechazar este activo.',
        'incorrect_user_accepted' => 'El activo que intentaste aceptar no fue asignado a ti.',
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