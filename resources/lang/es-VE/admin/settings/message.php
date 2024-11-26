<?php

return [

    'update' => [
        'error'                 => 'Un error ha ocurrido mientras se actualizaba. ',
        'success'               => 'Configuraciones actualizados con éxito.',
    ],
    'backup' => [
        'delete_confirm'        => '¿Está seguro de que desea eliminar este archivo de respaldo? Esta acción no puede se puede deshacer. ',
        'file_deleted'          => 'El archivo de respaldo fue eliminado satisfactoriamente. ',
        'generated'             => 'Se ha creado correctamente un nuevo archivo de copia de seguridad.',
        'file_not_found'        => 'Ese archivo de copia de seguridad no se pudo encontrar en el servidor.',
        'restore_warning'       => 'Sí, restaurarlo. Reconozco que esto sobrescribirá cualquier dato existente actualmente en la base de datos. Esto también cerrará la sesión de todos sus usuarios existentes (incluido usted).',
        'restore_confirm'       => '¿Está seguro que desea restaurar su base de datos desde :filename?'
    ],
    'restore' => [
        'success'               => 'Se ha restaurado la copia de seguridad de su sistema. Por favor, vuelva a iniciar sesión.'
    ],
    'purge' => [
        'error'     => 'Ha ocurrido un error mientras se realizaba el purgado. ',
        'validation_failed'     => 'Su confirmación de purga es incorrecta. Por favor, escriba la palabra "DELETE" en el cuadro de confirmación.',
        'success'               => 'Registros de borrado purgados correctamente.',
    ],
    'mail' => [
        'sending' => 'Enviando correo electrónico de prueba...',
        'success' => '¡Correo enviado!',
        'error' => 'El correo no pudo ser enviado.',
        'additional' => 'No se proporciona ningún mensaje de error adicional. Compruebe la configuración de su correo y el registro de errores de la aplicación.'
    ],
    'ldap' => [
        'testing' => 'Probando conexión LDAP, Binding & Query ...',
        '500' => 'Error 500 del servidor. Por favor, compruebe los registros de error de su servidor para más información.',
        'error' => 'Algo salió mal :(',
        'sync_success' => 'Una muestra de 10 usuarios devueltos desde el servidor LDAP basado en su configuración:',
        'testing_authentication' => 'Probando autenticación LDAP...',
        'authentication_success' => 'Usuario autenticado contra LDAP con éxito!'
    ],
    'webhook' => [
        'sending' => 'Enviando mensaje de prueba :app...',
        'success' => '¡Su integración :webhook_name funciona!',
        'success_pt1' => '¡Éxito! Compruebe el ',
        'success_pt2' => ' para su mensaje de prueba, y asegúrese de hacer clic en GUARDAR abajo para guardar su configuración.',
        '500' => 'Error 500 del servidor.',
        'error' => 'Algo salió mal. :app respondió con: :error_message',
        'error_redirect' => 'ERROR: 301/302 :endpoint devuelve una redirección. Por razones de seguridad, no seguimos redirecciones. Por favor, utilice el punto final actual.',
        'error_misc' => 'Algo salió mal. :( ',
    ]
];
