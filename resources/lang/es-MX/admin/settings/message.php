<?php

return [

    'update' => [
        'error'                 => 'Ha ocurrido un error al actualizar. ',
        'success'               => 'Parámetros actualizados correctamente.',
    ],
    'backup' => [
        'delete_confirm'        => 'Está seguro que desea eliminar este archivo de respaldo? Esta acción no puede ser revertida. ',
        'file_deleted'          => 'El archivo de respaldo fue eliminado satisfactoriamente. ',
        'generated'             => 'Un nuevo archivo de respaldo fue creado satisfactoriamente.',
        'file_not_found'        => 'El archivo de respaldo no se ha encontrado en el servidor.',
        'restore_warning'       => 'Sí, restaurarlo. Entiendo que esto sobrescribirá cualquier dato existente actualmente en la base de datos. Esto también cerrará la sesión de todos sus usuarios existentes (incluido usted).',
        'restore_confirm'       => '¿Está seguro que desea restaurar su base de datos desde :filename?'
    ],
    'purge' => [
        'error'     => 'Ha ocurrido un error mientras se realizaba el purgado. ',
        'validation_failed'     => 'Su confirmación de purga es incorrecta. Por favor, escriba la palabra "Borrar" en el cuadro de confirmación.',
        'success'               => 'Registros eliminados correctamente purgados.',
    ],
    'mail' => [
        'sending' => 'Enviando correo electrónico de prueba...',
        'success' => 'Correo enviado!',
        'error' => 'El correo no puede ser enviado.',
        'additional' => 'Ningún mensaje de error adicional proporcionado. Comprueba la configuración de tu correo y el registro de mensajes de tu aplicación.'
    ],
    'ldap' => [
        'testing' => 'Probando conexión LDAP, Enlace & Consulta ...',
        '500' => 'Error 500 del servidor. Por favor, compruebe los registros de mensaje de su servidor para más información.',
        'error' => 'Algo salió mal :(',
        'sync_success' => 'Una muestra de 10 usuarios devueltos desde el servidor LDAP basado en su configuración:',
        'testing_authentication' => 'Probando autenticación LDAP...',
        'authentication_success' => 'Usuario autenticado contra LDAP con éxito!'
    ],
    'webhook' => [
        'sending' => 'Enviando mensaje de prueba a :app...',
        'success_pt1' => '¡Éxito! Comprueba el ',
        'success_pt2' => ' canal para su mensaje de prueba, y asegúrese de hacer clic en GUARDAR abajo para guardar su configuración.',
        '500' => 'Error 500 del servidor.',
        'error' => 'Algo salió mal. :app respondió con: :error_message',
        'error_misc' => 'Algo salió mal. :( ',
    ]
];
