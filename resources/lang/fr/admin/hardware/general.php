<?php

return [
    'about_assets_title'           => 'A propos des actifs',
    'about_assets_text'            => 'Les actifs sont des éléments suivis par le numéro de série ou l\'étiquette de l\'actif. Ils ont tendance à être des éléments de valeur supérieure où l\'identification d\'un élément spécifique importe.',
    'archived'  				=> 'Retiré',
    'asset'  					=> 'Biens',
    'bulk_checkout'             => 'Attribuer les actifs',
    'bulk_checkin'              => 'Restitution d\'actifs',
    'checkin'  					=> 'Retour des Biens',
    'checkout'  				=> 'Commander l\'actif',
    'clone'  					=> 'Cloner le Bien',
    'deployable'  				=> 'Déployable',
    'deleted'  					=> 'Cet actif a été supprimé.',
    'edit'  					=> 'Editer le Bien',
    'model_deleted'  			=> 'Ce modèle d\'actifs a été supprimé. Vous devez restaurer le modèle avant de pouvoir restaurer l\'actif.',
    'model_invalid'             => 'The Model of this Asset is invalid.',
    'model_invalid_fix'         => 'The Asset should be edited to correct this before attempting to check it in or out.',
    'requestable'               => 'Réquisitionnable',
    'requested'				    => 'Demandé',
    'not_requestable'           => 'Non-réquisitionnable',
    'requestable_status_warning' => 'Ne pas modifier le statut de demande',
    'restore'  					=> 'Restaurer l\'actif',
    'pending'  					=> 'En attente',
    'undeployable'  			=> 'Non déployable',
    'view'  					=> 'Voir le Bien',
    'csv_error' => 'Vous avez une erreur dans votre fichier CSV :',
    'import_text' => '
    <p>
    Téléchargez un fichier CSV qui contient l\'historique des ressources. Les assets et les utilisateurs DOIVENT déjà exister dans le système, ou ils seront ignorés. La correspondance des assets pour l’importation de l’historique se produit avec le tag de l’actif. Nous allons essayer de trouver un utilisateur correspondant en fonction du nom d\'utilisateur que vous fournissez, et des critères que vous sélectionnez ci-dessous. Si vous ne sélectionnez aucun critère ci-dessous, il essaiera simplement de correspondre au format d\'utilisateur que vous avez configuré dans les paramètres généraux de l\'Admin &gt; .
    </p>

    <p>Les champs inclus dans le CSV doivent correspondre aux en-têtes : <strong>Étiquette d\'actif, Nom, date de paiement, date d\'enregistrement</strong>. Tous les champs supplémentaires seront ignorés. </p>

    <p>Date de check-in : les dates de check-in vides ou futures seront utilisées par l\'utilisateur associé. En excluant la colonne Date d\'enregistrement, vous créerez une date de check-in avec la date d\'aujourd\'hui.</p>
    ',
    'csv_import_match_f-l' => 'Essayez de faire correspondre les utilisateurs par prénom.nom (julie.tremblay)',
    'csv_import_match_initial_last' => 'Essayez de faire correspondre les utilisateurs par initial nom de famille (jtremblay)',
    'csv_import_match_first' => 'Essayez de faire correspondre les utilisateurs par leur prénom (julie)',
    'csv_import_match_email' => 'Essayer de faire correspondre l\'adresse de courrier électronique des utilisateurs au nom d\'utilisateur',
    'csv_import_match_username' => 'Essayer de faire correspondre les utilisateurs par nom d\'utilisateur',
    'error_messages' => 'Messages d\'erreur:',
    'success_messages' => 'Messages de succès:',
    'alert_details' => 'Voir ci-dessous pour plus de détails.',
    'custom_export' => 'Exportation personnalisée'
];
