<?php

return [

    'update' => [
        'error'                 => 'Une erreur a eu lieu pendant la mise à jour. ',
        'success'               => 'Les paramètres ont été mis à jour avec succès.',
    ],
    'backup' => [
        'delete_confirm'        => 'Êtes-vous certain de vouloir supprimer ce fichier de sauvegarde ? Cette action ne peut pas être annulée. ',
        'file_deleted'          => 'Le fichier de sauvegarde a été supprimé correctement. ',
        'generated'             => 'Un nouveau fichier de sauvegarde a été créé correctement.',
        'file_not_found'        => 'Ce fichier de sauvegarde n\'a pas pu être trouvé sur le serveur .',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Une erreur est survenue durant la purge. ',
        'validation_failed'     => 'Votre confirmation de purge est incorrecte. Merci d\'écrire le mot "DELETE" dans la fenêtre de confirmation.',
        'success'               => 'Les enregistrements supprimés ont bien été purgés.',
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
