<?php

return [

    'update' => [
        'error'                 => 'Si è verificato un errore durante l\'aggiornamento. ',
        'success'               => 'Impostazioni aggiornate correttamente.',
    ],
    'backup' => [
        'delete_confirm'        => 'Sei sicuro di voler cancellare questo file di backup? Questa operazione è irreversibile. ',
        'file_deleted'          => 'Il file di backup è stato cancellato con successo. ',
        'generated'             => 'Un nuovo file di backup è stato creato con successo.',
        'file_not_found'        => 'Quel file di backup non può essere trovato sul server.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Si è verificato un errore durante la pulizia. ',
        'validation_failed'     => 'La conferma dell\'eliminazione non è corretta. Digita "DELETE" nel box di conferma.',
        'success'               => 'I record cancellati sono stati correttamente eliminati.',
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
