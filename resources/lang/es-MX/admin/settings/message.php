<?php

return [

    'update' => [
        'error'                 => 'Ha ocurrido un error al actualizar. ',
        'success'               => 'Parámetros actualizados correctamente.',
    ],
    'backup' => [
<<<<<<< HEAD
        'delete_confirm'        => '¿Está seguro de que desea eliminar este archivo de respaldo? Esta acción no puede se puede deshacer. ',
        'file_deleted'          => 'El archivo de respaldo fue eliminado satisfactoriamente. ',
        'generated'             => 'Un nuevo archivo de respaldo fue creado satisfactoriamente.',
        'file_not_found'        => 'El archivo de respaldo no se ha encontrado en el servidor.',
        'restore_warning'       => 'Sí, restaurarlo. Entiendo que esto sobrescribirá cualquier dato existente actualmente en la base de datos. Esto también cerrará la sesión de todos sus usuarios existentes (incluido usted).',
        'restore_confirm'       => '¿Está seguro que desea restaurar su base de datos desde :filename?'
=======
        'delete_confirm'        => 'Está seguro que desea eliminar este archivo de respaldo? Esta acción no puede ser revertida. ',
        'file_deleted'          => 'El archivo de respaldo fue eliminado satisfactoriamente. ',
        'generated'             => 'Un nuevo archivo de respaldo fue creado satisfactoriamente.',
        'file_not_found'        => 'El archivo de respaldo no se ha encontrado en el servidor.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
>>>>>>> 64747d0fb (updates based on review)
    ],
    'purge' => [
        'error'     => 'Ha ocurrido un error mientras se realizaba el purgado. ',
        'validation_failed'     => 'Su confirmación de purga es incorrecta. Por favor, escriba la palabra "Borrar" en el cuadro de confirmación.',
        'success'               => 'Registros eliminados correctamente purgados.',
    ],
    'mail' => [
<<<<<<< HEAD
        'sending' => 'Enviando correo electrónico de prueba...',
        'success' => 'Correo enviado!',
        'error' => 'El correo no puede ser enviado.',
        'additional' => 'No se proporciona ningún mensaje de error adicional. Compruebe la configuración de su correo y el registro de errores de la aplicación.'
    ],
    'ldap' => [
        'testing' => 'Probando conexión LDAP, Enlace & Consulta ...',
        '500' => 'Error 500 del servidor. Por favor, compruebe los registros de error de su servidor para más información.',
        'error' => 'Algo salió mal :(',
        'sync_success' => 'Una muestra de 10 usuarios devueltos desde el servidor LDAP basado en su configuración:',
        'testing_authentication' => 'Probando autenticación LDAP...',
        'authentication_success' => 'Usuario autenticado contra LDAP con éxito!'
    ],
    'webhook' => [
        'sending' => 'Enviando mensaje de prueba a :app...',
        'success' => '¡Su Integración :webhook_name funciona!',
        'success_pt1' => '¡Éxito! Compruebe el ',
        'success_pt2' => ' canal para su mensaje de prueba, y asegúrese de hacer clic en GUARDAR abajo para guardar su configuración.',
        '500' => 'Error 500 del servidor.',
        'error' => 'Algo salió mal. :app respondió con: :error_message',
        'error_redirect' => 'ERROR: 301/302 :endpoint devuelve una redirección. Por razones de seguridad, no seguimos redirecciones. Por favor, utilice el punto final actual.',
        'error_misc' => 'Algo salió mal. :( ',
=======
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
>>>>>>> 64747d0fb (updates based on review)
    ]
];
