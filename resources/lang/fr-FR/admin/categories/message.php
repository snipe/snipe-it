<?php

return [

    'does_not_exist' => 'Cette catégorie n\'existe pas.',
    'assoc_models' => 'Cette catégorie est actuellement associée à au moins un modèle et ne peut pas être supprimée. Merci de mettre à jour les modèles afin de ne plus référencer cette catégorie et essayez à nouveau. ',
    'assoc_items' => 'Cette catégorie est actuellement associée à au moins un :asset_type et ne peut pas être supprimée. Merci de mettre à jour les :asset_type afin de ne plus référencer cette catégorie et essayez à nouveau. ',

    'create' => [
        'error' => 'Cette catégorie n\'a pas été créée, merci de réessayer.',
        'success' => 'Catégorie créée avec succès.',
    ],

    'update' => [
        'error' => 'La catégorie n\'a pas été mise à jour, merci de réessayer',
        'success' => 'Catégorie mise à jour avec succès.',
        'cannot_change_category_type' => 'Vous ne pouvez pas modifier le type de catégorie une fois qu\'il a été créé',
    ],

    'delete' => [
        'confirm' => 'Êtes-vous sûr·e de vouloir supprimer cette catégorie ?',
        'error' => 'Il y a eu un problème lors de la suppression de cette catégorie. Merci de réessayer.',
        'success' => 'Catégorie supprimée avec succès.',
        'bulk_success' => 'Catégorie supprimée avec succès.|Les catégories :count ont été supprimées avec succès.',
        'partial_success' => 'Catégorie supprimée avec succès. Voir les informations supplémentaires ci-dessous. | :count catégories ont été supprimées avec succès. Voir plus d\'informations ci-dessous.',
    ],

    'bulkedit' => [
        'warn' => 'Vous êtes sur le point de mettre à jour les propriétés du modèle suivant :|Vous êtes sur le point de modifier les propriétés des modèles :model_count suivants :',
        'no_selection' => 'Vous devez sélectionner au moins une catégorie à modifier',
        'no_changes' => 'Aucun champ n\'a été changé, donc rien n\'a été mis à jour.',
        'success' => 'Catégorie mise à jour avec succès.|:count catégories à jours.',
    ],

];
