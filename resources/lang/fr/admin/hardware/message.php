<?php

return [

    'undeployable' 		=> '<strong>Attention: </strong> Ce bien a été marqué non déployable.
                        Si ce statut a changé, veuillez l\'actualiser.',
    'does_not_exist' 	=> 'Ce bien n\'existe pas.',
    'does_not_exist_or_not_requestable' => 'Cet actif n\'existe pas ou ne peut pas être réquisitionné.',
    'assoc_users'	 	=> 'Ce bien est marqué sorti par un utilisateur et ne peut être supprimé. Veuillez d\'abord cliquer sur Retour de Biens, et réessayer.',

    'create' => [
        'error'   		=> 'Ce bien n\'a pas été créé, veuillez réessayer. :(',
        'success' 		=> 'Bien créé correctement. :)',
    ],

    'update' => [
        'error'   			=> 'Ce bien n\'a pas été actualisé, veuillez réessayer',
        'success' 			=> 'Bien actualisé correctement.',
        'nothing_updated'	=>  'Aucun champ n\'a été sélectionné, rien n\'a été actualisé.',
        'no_assets_selected'  =>  'Aucune ressource n\'a été sélectionnée, rien n\'a donc été mis à jour.',
    ],

    'restore' => [
        'error'   		=> 'L\'actif n\'a pas été restauré, veuillez réessayer',
        'success' 		=> 'Actif restauré correctement.',
    ],

    'audit' => [
        'error'   		=> 'Audit des actifs n\'a pas réussi. Veuillez réessayer.',
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
        'error'                 => 'Certains éléments n\'ont pas été correctement importés.',
        'errorDetail'           => 'Les éléments suivants n\'ont pas été importés à cause d\'erreurs.',
        'success'               => 'Votre fichier a bien été importé',
        'file_delete_success'   => 'Votre fichier a été correctement supprimé',
        'file_delete_error'      => 'Le fichier n’a pas pu être supprimé',
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
        'error'   		=> 'Le bien n\'a pas été demandé, merci d\'essayer à nouveau',
        'success' 		=> 'Le bien a été demandé correctement.',
        'canceled'      => 'La demande de paiement a été annulée',
    ],

];
