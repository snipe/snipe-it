<?php

return [

    'update' => [
        'error'                 => 'Un error ha ocurrido mientras se actualizaba. ',
        'success'               => 'Configuraciones actualizados con éxito.',
    ],
    'backup' => [
        'delete_confirm'        => '¿Estás seguro de que quieres eliminar este archivo de respaldo? Esta acción no puede deshacerse. ',
        'file_deleted'          => 'El archivo de respaldo fue eliminado satisfactoriamente. ',
        'generated'             => 'Un nuevo archivo de respaldo ha sido creado con éxito.',
        'file_not_found'        => 'El archivo de respaldo no puede ser encontrado en el servidor.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Ha ocurrido un error mientras se realizaba el purgado. ',
        'validation_failed'     => 'Su confirmación de purga es incorrecta. Por favor, escriba la palabra "DELETE" en el cuadro de confirmación.',
        'success'               => 'Registros de borrado purgados correctamente.',
    ],
    'mail' => [
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
    ]
];
