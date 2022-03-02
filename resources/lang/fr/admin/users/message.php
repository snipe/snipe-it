<?php

return array(

    'accepted'                  => 'Vous avez accepté cet actif.',
    'declined'                  => 'Vous avez refusé cet actif.',
    'bulk_manager_warn'	        => 'Vos utilisateurs ont été mis à jour avec succès, mais votre entrée de gestionnaire n\'a pas été enregistrée, car le gestionnaire que vous avez sélectionné était également dans la liste d\'utilisateurs à éditer, et les utilisateurs peuvent ne pas être leur propre gestionnaire. Sélectionnez à nouveau vos utilisateurs, à l\'exclusion du gestionnaire.',
    'user_exists'               => 'L\'utilisateur existe déjà !',
    'user_not_found'            => 'L\'utilisateur [:id] n\'existe pas.',
    'user_login_required'       => 'Le champ identifiant est obligatoire',
    'user_password_required'    => 'Le mot de passe est obligatoire.',
    'insufficient_permissions'  => 'Droits insuffisants.',
    'user_deleted_warning'      => 'Cet utilisateur a été supprimé. Vous devez le restaurer pour pouvoir l\'éditer ou lui assigner de nouveaux actifs.',
    'ldap_not_configured'        => 'L\'intégration LDAP n\'a pas été configuré pour cette installation .',
    'password_resets_sent'      => 'Les utilisateurs sélectionnés qui sont activés et ont une adresse e-mail valide ont reçu un lien de réinitialisation du mot de passe.',
    'password_reset_sent'       => 'Un lien de réinitialisation du mot de passe a été envoyé à :email!',


    'success' => array(
        'create'    => 'L’utilisateur a été créé avec succès.',
        'update'    => 'L’utilisateur a été mis à jour avec succès.',
        'update_bulk'    => 'Utilisateurs mis à jour avec succès !',
        'delete'    => 'L’utilisateur a été supprimé avec succès.',
        'ban'       => 'L’utilisateur a été banni avec succès.',
        'unban'     => 'L’utilisateur a été réhabilité avec succès.',
        'suspend'   => 'L’utilisateur a été suspendu avec succès.',
        'unsuspend' => 'L’utilisateur a été activé avec succès.',
        'restored'  => 'L’utilisateur a été restauré avec succès.',
        'import'    => 'Les utilisateurs ont été importés correctement.',
    ),

    'error' => array(
        'create' => 'Un problème a eu lieu pendant la création de l\'utilisateur. Veuillez essayer à nouveau.',
        'update' => 'Un problème a eu lieu pendant la mise à jour de l\'utilisateur. Veuillez essayer à nouveau.',
        'delete' => 'Un problème a eu lieu pendant la suppression de l\'utilisateur. Veuillez essayer à nouveau.',
        'delete_has_assets' => 'Cet utilisateur a des éléments assignés et n\'a pas pu être supprimé.',
        'unsuspend' => 'Un problème a eu lieu pendant la réhabilitation de l\'utilisateur. Veuillez essayer à nouveau.',
        'import'    => 'Il y a eu un problème lors de l\'importation des utilisateurs. Veuillez réessayer.',
        'asset_already_accepted' => 'Cet actif a déjà été accepté.',
        'accept_or_decline' => 'Vous devez accepter ou refuser cet actif.',
        'incorrect_user_accepted' => 'Le bien que vous avez tenté d\'accepter ne vous avait pas été attribué.',
        'ldap_could_not_connect' => 'Impossible de se connecter au serveur LDAP . S\'il vous plaît vérifier la configuration de votre serveur LDAP dans le fichier de configuration LDAP . <br> Erreur du serveur LDAP :',
        'ldap_could_not_bind' => 'Impossible de se connecter au serveur LDAP . S\'il vous plaît vérifier la configuration de votre serveur LDAP dans le fichier de configuration LDAP . <br> Erreur de serveur LDAP : ',
        'ldap_could_not_search' => 'Impossible de rechercher le serveur LDAP . S\'il vous plaît vérifier la configuration de votre serveur LDAP dans le fichier de configuration LDAP . <br> Erreur de serveur LDAP :',
        'ldap_could_not_get_entries' => 'Impossible d\'obtenir les entrées du serveur LDAP . S\'il vous plaît vérifier la configuration de votre serveur LDAP dans le fichier de configuration LDAP . <br> Erreur de serveur LDAP :',
        'password_ldap' => 'Le mot de passe de ce compte est géré par LDAP / Active Directory. Veuillez contacter votre service informatique pour changer votre mot de passe.',
    ),

    'deletefile' => array(
        'error'   => 'Le fichier n\'a pas pu être supprimé. Veuillez réessayer.',
        'success' => 'Le fichier a été supprimé correctement.',
    ),

    'upload' => array(
        'error'   => 'Le(s) fichier(s) n\'ont pas pu être téléversé. Veuillez réessayer.',
        'success' => 'Le(s) fichier(s) ont été téléversé correctement.',
        'nofiles' => 'Vous n\'avez pas sélectionné de fichier pour le téléversement',
        'invalidfiles' => 'Un ou plusieurs de vos fichiers sont trop gros, ou sont d\'un type non autorisé. Les types de fichiers autorisés sont png, gif, jpg, doc, docx, pdf et txt.',
    ),

);
