<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Ce bien n\'existe pas.',
    'does_not_exist_var'=> 'Actif avec le tag :asset_tag introuvable.',
    'no_tag' 	        => 'Aucune étiquette d\'actif fournie.',
    'does_not_exist_or_not_requestable' => 'Cet actif n\'existe pas ou ne peut pas être demandé.',
    'assoc_users'	 	=> 'Ce bien est marqué sorti par un utilisateur et ne peut être supprimé. Veuillez d\'abord cliquer sur Retour de Biens, et réessayer.',
    'warning_audit_date_mismatch' 	=> 'La prochaine date d\'audit de cet actif (:next_audit_date) est antérieure à la dernière date d\'audit (:last_audit_date). Veuillez mettre à jour la prochaine date d\'audit.',

    'create' => [
        'error'   		=> 'Ce bien n\'a pas été créé, veuillez réessayer. :(',
        'success' 		=> 'Bien créé correctement. :)',
        'success_linked' => 'L\'actif avec le tag :tag a été créé avec succès. <strong><a href=":link" style="color: white;">Cliquez ici pour voir</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Ce bien n\'a pas été actualisé, veuillez réessayer',
        'success' 			=> 'Bien actualisé correctement.',
        'encrypted_warning' => 'Ressource mise à jour avec succès, mais les champs personnalisés chiffrés ne sont pas dus aux permissions',
        'nothing_updated'	=>  'Aucun champ n\'a été sélectionné, rien n\'a été actualisé.',
        'no_assets_selected'  =>  'Aucune ressource n\'a été sélectionnée, rien n\'a donc été mis à jour.',
        'assets_do_not_exist_or_are_invalid' => 'Les ressources sélectionnées ne peuvent pas être mises à jour.',
    ],

    'restore' => [
        'error'   		=> 'L\'actif n\'a pas été restauré, veuillez réessayer',
        'success' 		=> 'Actif restauré correctement.',
        'bulk_success' 		=> 'Actif restauré avec succès.',
        'nothing_updated'   => 'Aucun actif n\'a été sélectionné, donc rien n\'a été restauré.', 
    ],

    'audit' => [
        'error'   		=> 'Échec de l\'audit d\'actif : :error ',
        'success' 		=> 'Audit des actifs consigné avec succès.',
    ],


    'deletefile' => [
        'error'   => 'Le fichier n\'a pas été détruit. Veuillez réessayer.',
        'success' => 'Fichier détruit correctement.',
    ],

    'upload' => [
        'error'   => 'Le(s) fichier(s) n\'ont pas pu être téléversé. Veuillez réessayer.',
        'success' => 'Le(s) fichier(s) ont été téléversé correctement.',
        'nofiles' => 'Vous n\'avez pas sélectionné de fichier pour le téléchargement ou le fichier que vous essayez de télécharger est trop gros',
        'invalidfiles' => 'Un ou plusieurs de vos fichiers sont trop gros, ou sont d\'un type non autorisé. Les types de fichiers autorisés sont png, gif, jpg, doc, docx, pdf et txt.',
    ],

    'import' => [
        'import_button'         => 'Process Import',
        'error'                 => 'Certains éléments n\'ont pas été correctement importés.',
        'errorDetail'           => 'Les éléments suivants n\'ont pas été importés à cause d\'erreurs.',
        'success'               => 'Votre fichier a bien été importé',
        'file_delete_success'   => 'Votre fichier a été correctement supprimé',
        'file_delete_error'      => 'Le fichier n’a pas pu être supprimé',
        'file_missing' => 'Le fichier sélectionné est manquant',
        'header_row_has_malformed_characters' => 'Un ou plusieurs attributs dans la ligne d\'en-tête contiennent des caractères UTF-8 invalides',
        'content_row_has_malformed_characters' => 'Un ou plusieurs attributs dans la première ligne de contenu contiennent des caractères UTF-8 invalides',
    ],


    'delete' => [
        'confirm'   	=> 'Etes-vous sûr de vouloir supprimer ce bien?',
        'error'   		=> 'Il y a eu un problème en supprimant ce bien. Veuillez réessayer.',
        'nothing_updated'   => 'Aucun actif n\'a été sélectionné, donc rien n\'a été supprimé.',
        'success' 		=> 'Ce bien a été supprimé correctement.',
    ],

    'checkout' => [
        'error'   		=> 'Ce bien n\'a pas été sorti, veuillez réessayer',
        'success' 		=> 'Ce bien a été sorti correctement.',
        'user_does_not_exist' => 'Cet utilisateur est invalide. Veuillez réessayer.',
        'not_available' => 'Ce bien n\'est pas disponible pour être sorti!',
        'no_assets_selected' => 'Vous devez sélectionner au moins un élément de la liste',
    ],

    'checkin' => [
        'error'   		=> 'Ce bien n\'a pas été retourné, veuillez réessayer',
        'success' 		=> 'Ce bien a été retourné correctement.',
        'user_does_not_exist' => 'Cet utilisateur est invalide. Veuillez réessayer.',
        'already_checked_in'  => 'Ce bien est déjà dissocié.',

    ],

    'requests' => [
        'error'   		=> 'L\'actif n\'a pas été demandé, merci d\'essayer à nouveau',
        'success' 		=> 'L\'actif a été demandé avec succès.',
        'canceled'      => 'La demande d\'association a été annulée avec succès',
    ],

];
