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
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Ha ocurrido un error mientras se realizaba el purgado. ',
        'validation_failed'     => 'Su confirmación de purga es incorrecta. Por favor, escriba la palabra "Borrar" en el cuadro de confirmación.',
        'success'               => 'Registros eliminados correctamente purgados.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Correo enviado!',
        'error' => 'El correo no puede ser enviado.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Algo salió mal :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Algo salió mal.',
    ]
];
