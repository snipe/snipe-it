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
        'sending' => 'Envoi du message électronique de test...',
        'success' => 'Courrier électronique envoyé !',
        'error' => 'Le courrier électronique n\'a pas pu être envoyé.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Test de la connexion, de la liaison et de la requête LDAP ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Une erreur est survenue :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Test de l\'authentification LDAP...',
        'authentication_success' => 'Utilisateur authentifié contre LDAP avec succès !'
    ],
    'slack' => [
        'sending' => 'Envoi du message de test Slack...',
        'success_pt1' => 'Succès ! Vérifiez le ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Erreur du serveur.',
        'error' => 'Une erreur est survenue.',
    ]
];
